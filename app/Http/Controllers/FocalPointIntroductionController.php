<?php

namespace App\Http\Controllers;

use App\Models\BudgetEntity;
use App\Models\FocalPointIntroduction;
use App\Models\Inbox;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class FocalPointIntroductionController extends Controller
{
    public function index(Request $request): View
    {
        $query = FocalPointIntroduction::query()
            ->with([
                'budgetEntity:id,entity_code,name_en,name_ps,name_fa',
                'creator:id,name',
                'reviewer:id,name',
            ])
            ->withCount('focalPoints');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('letter_number', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('approval_notes', 'like', "%{$search}%")
                    ->orWhereHas(
                        'budgetEntity',
                        function ($entityQuery) use ($search): void {
                            $entityQuery
                                ->where('entity_code', 'like', "%{$search}%")
                                ->orWhere('name_en', 'like', "%{$search}%")
                                ->orWhere('name_ps', 'like', "%{$search}%")
                                ->orWhere('name_fa', 'like', "%{$search}%");
                        }
                    );
            });
        }

        if ($request->filled('budget_entity_id')) {
            $query->where(
                'budget_entity_id',
                $request->integer('budget_entity_id')
            );
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('from_date')) {
            $query->whereDate(
                'received_date',
                '>=',
                $request->input('from_date')
            );
        }

        if ($request->filled('to_date')) {
            $query->whereDate(
                'received_date',
                '<=',
                $request->input('to_date')
            );
        }

        $introductions = $query
            ->latest('received_date')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $budgetEntities = BudgetEntity::query()
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
            'total' => FocalPointIntroduction::query()->count(),
            'received' => FocalPointIntroduction::query()
                ->where('status', 'received')
                ->count(),
            'under_review' => FocalPointIntroduction::query()
                ->where('status', 'under_review')
                ->count(),
            'approved' => FocalPointIntroduction::query()
                ->where('status', 'approved')
                ->count(),
            'completed' => FocalPointIntroduction::query()
                ->where('status', 'completed')
                ->count(),
        ];

        return view('focal-point-introductions.index', [
            'introductions' => $introductions,
            'budgetEntities' => $budgetEntities,
            'stats' => $stats,
        ]);
    }

    public function create(): View
    {
        $budgetEntities = BudgetEntity::query()
            ->where('status', true)
            ->orderBy('name_en')
            ->orderBy('name_fa')
            ->get();

        $inboxes = Inbox::query()
            ->latest('id')
            ->limit(200)
            ->get();

        return view(
            'focal-point-introductions.create',
            compact('budgetEntities', 'inboxes')
        );
    }
     

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateIntroduction($request);
        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request
                ->file('attachment')
                ->store('focal-point-introductions', 'public');

            $validated['attachment'] = $attachmentPath;
        }

        $validated['created_by'] = auth()->id();
        $this->applyReviewMetadata($validated);

        try {
            $introduction = DB::transaction(
                fn (): FocalPointIntroduction =>
                    FocalPointIntroduction::create($validated)
            );

            $this->writeAudit(
                'focal_point_introduction_created',
                $introduction,
                null,
                $introduction->fresh()->toArray()
            );

            if (Route::has('focal-points.registration')) {
                return redirect()
                    ->route('focal-points.registration', [
                        'budget_entity_id' => $introduction->budget_entity_id,
                        'introduction_id' => $introduction->id,
                    ])
                    ->with(
                        'success',
                        'Introduction letter registered successfully. You can now register the focal point.'
                    );
            }

            return redirect()
                ->route('focal-point-introductions.index')
                ->with(
                    'success',
                    'Introduction letter registered successfully.'
                );
        } catch (Throwable $exception) {
            if (
                $attachmentPath &&
                Storage::disk('public')->exists($attachmentPath)
            ) {
                Storage::disk('public')->delete($attachmentPath);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'The introduction letter could not be registered.'
                );
        }
    }

    public function show(
        FocalPointIntroduction $focalPointIntroduction
    ): View {
        $focalPointIntroduction->load([
            'budgetEntity',
            'creator',
            'reviewer',
            'focalPoints' => function ($query): void {
                $query->latest('id');
            },
        ]);

        $focalPointIntroduction->loadCount('focalPoints');

        return view('focal-point-introductions.show', [
            'introduction' => $focalPointIntroduction,
            'focalPointIntroduction' => $focalPointIntroduction,
        ]);
    }

    public function edit(
        FocalPointIntroduction $focalPointIntroduction
    ): View {
        $budgetEntities = BudgetEntity::query()
            ->where(function ($query) use ($focalPointIntroduction): void {
                $query
                    ->where('status', true)
                    ->orWhereKey($focalPointIntroduction->budget_entity_id);
            })
            ->orderBy('name_en')
            ->orderBy('name_fa')
            ->get();

        $inboxes = Inbox::query()
            ->latest('id')
            ->limit(200)
            ->get();

        return view('focal-point-introductions.edit', [
            'introduction' => $focalPointIntroduction,
            'focalPointIntroduction' => $focalPointIntroduction,
            'budgetEntities' => $budgetEntities,
            'inboxes' => $inboxes,
        ]);
    }

    public function update(
        Request $request,
        FocalPointIntroduction $focalPointIntroduction
    ): RedirectResponse {
        $validated = $this->validateIntroduction(
            $request,
            $focalPointIntroduction
        );

        $oldValues = $focalPointIntroduction->toArray();
        $oldAttachment = $focalPointIntroduction->attachment;
        $newAttachment = null;

        if ($request->hasFile('attachment')) {
            $newAttachment = $request
                ->file('attachment')
                ->store('focal-point-introductions', 'public');

            $validated['attachment'] = $newAttachment;
        }

        $this->applyReviewMetadata($validated);

        try {
            DB::transaction(function () use (
                $focalPointIntroduction,
                $validated
            ): void {
                $focalPointIntroduction->update($validated);
            });

            if (
                $newAttachment &&
                $oldAttachment &&
                $oldAttachment !== $newAttachment &&
                Storage::disk('public')->exists($oldAttachment)
            ) {
                Storage::disk('public')->delete($oldAttachment);
            }

            $this->writeAudit(
                'focal_point_introduction_updated',
                $focalPointIntroduction,
                $oldValues,
                $focalPointIntroduction->fresh()->toArray()
            );

            return redirect()
                ->route(
                    'focal-point-introductions.show',
                    $focalPointIntroduction
                )
                ->with(
                    'success',
                    'Introduction letter updated successfully.'
                );
        } catch (Throwable $exception) {
            if (
                $newAttachment &&
                Storage::disk('public')->exists($newAttachment)
            ) {
                Storage::disk('public')->delete($newAttachment);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'The introduction letter could not be updated.'
                );
        }
    }

    public function updateStatus(
        Request $request,
        FocalPointIntroduction $focalPointIntroduction
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in($this->allowedStatuses()),
            ],
            'approval_notes' => [
                'nullable',
                'string',
                'max:3000',
            ],
        ]);

        $oldValues = $focalPointIntroduction->toArray();
        $this->applyReviewMetadata($validated);
        $focalPointIntroduction->update($validated);

        $this->writeAudit(
            'focal_point_introduction_status_changed',
            $focalPointIntroduction,
            $oldValues,
            $focalPointIntroduction->fresh()->toArray()
        );

        return back()->with(
            'success',
            'Introduction-letter status updated successfully.'
        );
    }

    public function downloadAttachment(
        FocalPointIntroduction $focalPointIntroduction
    ): BinaryFileResponse {
        $path = $focalPointIntroduction->attachment;

        abort_unless(
            $path && Storage::disk('public')->exists($path),
            404,
            'Attachment not found.'
        );

        return response()->download(
            Storage::disk('public')->path($path),
            basename($path)
        );
    }

    public function destroy(
        FocalPointIntroduction $focalPointIntroduction
    ): RedirectResponse {
        $focalPointIntroduction->loadCount('focalPoints');

        if ($focalPointIntroduction->focal_points_count > 0) {
            return back()->with(
                'error',
                'This introduction letter is connected to focal-point records and cannot be deleted.'
            );
        }

        $oldValues = $focalPointIntroduction->toArray();
        $attachment = $focalPointIntroduction->attachment;

        try {
            DB::transaction(function () use (
                $focalPointIntroduction
            ): void {
                $focalPointIntroduction->delete();
            });

            if (
                $attachment &&
                Storage::disk('public')->exists($attachment)
            ) {
                Storage::disk('public')->delete($attachment);
            }

            $this->writeAudit(
                'focal_point_introduction_deleted',
                $focalPointIntroduction,
                $oldValues,
                null
            );

            return redirect()
                ->route('focal-point-introductions.index')
                ->with(
                    'success',
                    'Introduction letter deleted successfully.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                'The introduction letter could not be deleted.'
            );
        }
    }

    private function validateIntroduction(
        Request $request,
        ?FocalPointIntroduction $introduction = null
    ): array {
        $introductionId = $introduction?->id;
        $inboxTable = (new Inbox())->getTable();

        return $request->validate([
            'budget_entity_id' => [
                'required',
                'integer',
                Rule::exists('budget_entities', 'id')->whereNull('deleted_at'),
            ],
            'inbox_id' => [
                'nullable',
                'integer',
                Rule::exists($inboxTable, 'id'),
            ],
            'letter_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique(
                    'focal_point_introductions',
                    'letter_number'
                )
                    ->where(
                        fn ($query) => $query->where(
                            'budget_entity_id',
                            $request->input('budget_entity_id')
                        )
                    )
                    ->ignore($introductionId),
            ],
            'letter_date' => ['required', 'date'],
            'received_date' => ['required', 'date'],
            'subject' => ['required', 'string', 'max:1000'],
            'number_of_nominees' => [
                'required',
                'integer',
                'min:1',
                'max:50',
            ],
            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,doc,docx',
                'max:10240',
            ],
            'status' => [
                'required',
                Rule::in($this->allowedStatuses()),
            ],
            'approval_notes' => [
                'nullable',
                'string',
                'max:3000',
            ],
        ]);
    }

    private function applyReviewMetadata(array &$data): void
    {
        if (
            in_array(
                $data['status'],
                ['returned', 'approved', 'rejected', 'completed'],
                true
            )
        ) {
            $data['reviewed_by'] = auth()->id();
            $data['reviewed_at'] = now();
        }
    }

    private function allowedStatuses(): array
    {
        return [
            'received',
            'under_review',
            'returned',
            'approved',
            'rejected',
            'completed',
        ];
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