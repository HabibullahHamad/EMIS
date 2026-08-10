<?php

namespace App\Http\Controllers;

use App\Models\BudgetEntity;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Throwable;

class BudgetEntityController extends Controller
{
    public function index(Request $request): View
    {
        $query = BudgetEntity::query()
            ->with([
                'parent:id,entity_code,name_en,name_ps,name_fa',
                'creator:id,name',
            ])
            ->withCount([
                'children',
                'introductions',
                'focalPoints',
            ]);

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('entity_code', 'like', "%{$search}%")
                    ->orWhere('short_name', 'like', "%{$search}%")
                    ->orWhere('name_en', 'like', "%{$search}%")
                    ->orWhere('name_ps', 'like', "%{$search}%")
                    ->orWhere('name_fa', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->input('entity_type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->boolean('status'));
        }

        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->integer('parent_id'));
        }

        $budgetEntities = $query
            ->orderByDesc('status')
            ->orderBy('name_en')
            ->orderBy('name_fa')
            ->paginate(20)
            ->withQueryString();

        $parents = BudgetEntity::query()
            ->where('status', true)
            ->orderBy('name_en')
            ->orderBy('name_fa')
            ->get([
                'id',
                'entity_code',
                'name_en',
                'name_ps',
                'name_fa',
            ]);

        $stats = [
            'total' => BudgetEntity::query()->count(),
            'active' => BudgetEntity::query()->where('status', true)->count(),
            'inactive' => BudgetEntity::query()->where('status', false)->count(),
            'ministries' => BudgetEntity::query()
                ->where('entity_type', 'ministry')
                ->count(),
        ];

        return view(
            'budget-entities.index',
            compact('budgetEntities', 'parents', 'stats')
        );
    }

    public function create(): View
    {
        $parents = BudgetEntity::query()
            ->where('status', true)
            ->orderBy('name_en')
            ->orderBy('name_fa')
            ->get();

        return view('budget-entities.create', compact('parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateBudgetEntity($request);
        $validated['entity_code'] = $this->normalizeCode($validated['entity_code']);
        $validated['created_by'] = auth()->id();

        try {
            $budgetEntity = DB::transaction(
                fn (): BudgetEntity => BudgetEntity::create($validated)
            );

            $this->writeAudit(
                'budget_entity_created',
                $budgetEntity,
                null,
                $budgetEntity->fresh()->toArray()
            );

            if (Route::has('focal-point-introductions.create')) {
                return redirect()
                    ->route('focal-point-introductions.create', [
                        'budget_entity_id' => $budgetEntity->id,
                    ])
                    ->with(
                        'success',
                        'Budget entity registered successfully. You can now register its introduction letter.'
                    );
            }

            return redirect()
                ->route('budget-entities.index')
                ->with('success', 'Budget entity registered successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'The budget entity could not be registered.');
        }
    }

    public function show(BudgetEntity $budgetEntity): View
    {
        $budgetEntity->load([
            'parent',
            'children',
            'creator',
            'introductions' => function ($query): void {
                $query->latest('received_date')->latest('id');
            },
            'focalPoints' => function ($query): void {
                $query->latest('id');
            },
        ]);

        $budgetEntity->loadCount([
            'children',
            'introductions',
            'focalPoints',
        ]);

        return view('budget-entities.show', compact('budgetEntity'));
    }

    public function edit(BudgetEntity $budgetEntity): View
    {
        $parents = BudgetEntity::query()
            ->whereKeyNot($budgetEntity->id)
            ->where('status', true)
            ->orderBy('name_en')
            ->orderBy('name_fa')
            ->get();

        return view(
            'budget-entities.edit',
            compact('budgetEntity', 'parents')
        );
    }

    public function update(
        Request $request,
        BudgetEntity $budgetEntity
    ): RedirectResponse {
        $validated = $this->validateBudgetEntity($request, $budgetEntity);
        $validated['entity_code'] = $this->normalizeCode($validated['entity_code']);

        $this->ensureValidParent(
            $budgetEntity,
            isset($validated['parent_id'])
                ? (int) $validated['parent_id']
                : null
        );

        $oldValues = $budgetEntity->toArray();

        try {
            DB::transaction(function () use ($budgetEntity, $validated): void {
                $budgetEntity->update($validated);
            });

            $this->writeAudit(
                'budget_entity_updated',
                $budgetEntity,
                $oldValues,
                $budgetEntity->fresh()->toArray()
            );

            return redirect()
                ->route('budget-entities.show', $budgetEntity)
                ->with('success', 'Budget entity updated successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'The budget entity could not be updated.');
        }
    }

    public function destroy(BudgetEntity $budgetEntity): RedirectResponse
    {
        $budgetEntity->loadCount([
            'children',
            'introductions',
            'focalPoints',
        ]);

        if ($budgetEntity->children_count > 0) {
            return back()->with(
                'error',
                'This budget entity has child entities and cannot be deleted.'
            );
        }

        if ($budgetEntity->introductions_count > 0) {
            return back()->with(
                'error',
                'This budget entity has introduction-letter history and cannot be deleted. Set it to inactive instead.'
            );
        }

        if ($budgetEntity->focal_points_count > 0) {
            return back()->with(
                'error',
                'This budget entity has focal-point records and cannot be deleted. Set it to inactive instead.'
            );
        }

        $oldValues = $budgetEntity->toArray();

        try {
            DB::transaction(function () use ($budgetEntity): void {
                $budgetEntity->delete();
            });

            $this->writeAudit(
                'budget_entity_deleted',
                $budgetEntity,
                $oldValues,
                null
            );

            return redirect()
                ->route('budget-entities.index')
                ->with('success', 'Budget entity deleted successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                'The budget entity could not be deleted.'
            );
        }
    }

    private function validateBudgetEntity(
        Request $request,
        ?BudgetEntity $budgetEntity = null
    ): array {
        $budgetEntityId = $budgetEntity?->id;

        return $request->validate([
            'entity_code' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z0-9_-]+$/',
                Rule::unique('budget_entities', 'entity_code')
                    ->ignore($budgetEntityId)
                    ->whereNull('deleted_at'),
            ],
            'name_en' => ['nullable', 'string', 'max:255'],
            'name_ps' => ['nullable', 'string', 'max:255'],
            'name_fa' => ['required', 'string', 'max:255'],
            'short_name' => ['nullable', 'string', 'max:100'],
            'entity_type' => [
                'required',
                Rule::in([
                    'ministry',
                    'independent_directorate',
                    'general_directorate',
                    'state_owned_enterprise',
                    'provincial_entity',
                    'budget_unit',
                    'other',
                ]),
            ],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('budget_entities', 'id')->whereNull('deleted_at'),
                Rule::notIn($budgetEntityId ? [$budgetEntityId] : []),
            ],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'boolean'],
            'description' => ['nullable', 'string', 'max:3000'],
        ]);
    }

    private function ensureValidParent(
        BudgetEntity $budgetEntity,
        ?int $parentId
    ): void {
        if (!$parentId) {
            return;
        }

        if ($parentId === $budgetEntity->id) {
            abort(422, 'A budget entity cannot be its own parent.');
        }

        $currentParentId = $parentId;
        $visited = [];

        while ($currentParentId) {
            if (in_array($currentParentId, $visited, true)) {
                abort(422, 'The selected parent creates an invalid hierarchy cycle.');
            }

            $visited[] = $currentParentId;

            if ($currentParentId === $budgetEntity->id) {
                abort(422, 'A child entity cannot be selected as the parent.');
            }

            $currentParentId = BudgetEntity::query()
                ->whereKey($currentParentId)
                ->value('parent_id');
        }
    }

    private function normalizeCode(string $code): string
    {
        return strtoupper(
            preg_replace('/[^A-Za-z0-9_-]/', '', trim($code)) ?: ''
        );
    }

    private function writeAudit(
        string $action,
        object $model,
        ?array $oldValues,
        ?array $newValues
    ): void {
        if (!function_exists('audit_log')) {
            return;
        }

        try {
            audit_log($action, $model, $oldValues, $newValues);
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}