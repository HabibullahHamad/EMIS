<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\SystemSettingHistory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsHistoryController extends Controller
{
    /**
     * Display the Settings audit history.
     */
    public function __invoke(
        Request $request
    ): View {
        /*
        |--------------------------------------------------------------------------
        | Safe filters
        |--------------------------------------------------------------------------
        */

        $filters = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:150',
            ],

            'group' => [
                'nullable',
                'string',
                'max:100',
            ],

            'action' => [
                'nullable',
                'string',
                'in:created,updated,deleted',
            ],

            'changed_by' => [
                'nullable',
                'integer',
                'exists:users,id',
            ],

            'date_from' => [
                'nullable',
                'date',
            ],

            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Registered Settings groups
        |--------------------------------------------------------------------------
        */

        $sections = config(
            'emis-settings.sections',
            []
        );

        $groups = collect($sections)
            ->mapWithKeys(
                function (
                    array $section,
                    string $key
                ): array {
                    $group = (string) (
                        $section['group']
                        ?? $key
                    );

                    $title = $section['title']
                        ?? $key;

                    $translated = is_string($title)
                        ? __($title)
                        : $key;

                    if (!is_string($translated)) {
                        $translated = $key;
                    }

                    if ($translated === $title) {
                        $translated = str($key)
                            ->replace('_', ' ')
                            ->replace('-', ' ')
                            ->title()
                            ->toString();
                    }

                    return [
                        $group => $translated,
                    ];
                }
            )
            ->sort();

        /*
        |--------------------------------------------------------------------------
        | History query
        |--------------------------------------------------------------------------
        */

        $query = SystemSettingHistory::query()
            ->with([
                'changedBy',
            ])
            ->latest('id');

        $query->when(
            isset($filters['search'])
            && $filters['search'] !== '',
            function (
                Builder $query
            ) use ($filters): void {
                $search = trim(
                    $filters['search']
                );

                $query->where(
                    function (
                        Builder $query
                    ) use ($search): void {
                        $query
                            ->where(
                                'setting_group',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'setting_key',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'ip_address',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'route_name',
                                'like',
                                "%{$search}%"
                            );
                    }
                );
            }
        );

        $query->when(
            isset($filters['group'])
            && $filters['group'] !== '',
            fn (
                Builder $query
            ): Builder =>
                $query->group(
                    $filters['group']
                )
        );

        $query->when(
            isset($filters['action'])
            && $filters['action'] !== '',
            fn (
                Builder $query
            ): Builder =>
                $query->action(
                    $filters['action']
                )
        );

        $query->when(
            isset($filters['changed_by']),
            fn (
                Builder $query
            ): Builder =>
                $query->where(
                    'changed_by',
                    $filters['changed_by']
                )
        );

        $query->when(
            isset($filters['date_from']),
            fn (
                Builder $query
            ): Builder =>
                $query->whereDate(
                    'created_at',
                    '>=',
                    $filters['date_from']
                )
        );

        $query->when(
            isset($filters['date_to']),
            fn (
                Builder $query
            ): Builder =>
                $query->whereDate(
                    'created_at',
                    '<=',
                    $filters['date_to']
                )
        );

        $histories = $query
            ->paginate(25)
            ->withQueryString();

        return view(
            'settings.history',
            [
                'histories' =>
                    $histories,

                'groups' =>
                    $groups,

                'filters' =>
                    $filters,

                'sections' =>
                    $sections,

                'actions' => [
                    'created' =>
                        'Created',

                    'updated' =>
                        'Updated',

                    'deleted' =>
                        'Deleted',
                ],
            ]
        );
    }
}