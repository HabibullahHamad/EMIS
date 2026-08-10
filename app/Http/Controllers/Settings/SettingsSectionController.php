<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateSettingsSectionRequest;
use App\Services\Settings\SystemSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class SettingsSectionController extends Controller
{
    /**
     * Settings service.
     */
    public function __construct(
        private readonly SystemSettingService $settings
    ) {
    }

    /**
     * Display one Settings section.
     *
     * Example:
     *
     * /admin/settings/general
     */
    public function edit(
        string $section
    ): View {
        $section = strtolower(
            trim($section)
        );

        /*
        |--------------------------------------------------------------------------
        | Load all registered Settings sections
        |--------------------------------------------------------------------------
        */

        $sections = config(
            'emis-settings.sections',
            []
        );

        /*
         * Reject sections that are not registered.
         */
        abort_unless(
            isset($sections[$section]),
            404
        );

        $sectionConfig =
            $sections[$section];

        $fields =
            $sectionConfig['fields']
            ?? [];

        $group =
            $sectionConfig['group']
            ?? $section;

        /*
        |--------------------------------------------------------------------------
        | Load stored database values
        |--------------------------------------------------------------------------
        */

        $storedValues =
            $this->settings->group(
                $group
            );

        /*
        |--------------------------------------------------------------------------
        | Merge database values with configuration defaults
        |--------------------------------------------------------------------------
        |
        | Database value has priority.
        |
        | If a value has never been saved, use the default from:
        |
        | config/emis-settings.php
        |
        */

        $values = [];

        foreach (
            $fields
            as $key => $definition
        ) {
            if (!is_array($definition)) {
                continue;
            }

            if (
                array_key_exists(
                    $key,
                    $storedValues
                )
            ) {
                $values[$key] =
                    $storedValues[$key];

                continue;
            }

            $values[$key] =
                $definition['default']
                ?? null;
        }

        /*
        |--------------------------------------------------------------------------
        | Sort navigation and fields
        |--------------------------------------------------------------------------
        */

        uasort(
            $sections,
            fn (
                array $left,
                array $right
            ): int =>
                ($left['order'] ?? 999)
                <=>
                ($right['order'] ?? 999)
        );

        uasort(
            $fields,
            fn (
                array $left,
                array $right
            ): int =>
                ($left['order'] ?? 999)
                <=>
                ($right['order'] ?? 999)
        );

        return view(
            'settings.section',
            [
                'section' =>
                    $section,

                'sectionConfig' =>
                    $sectionConfig,

                'sections' =>
                    $sections,

                'fields' =>
                    $fields,

                'values' =>
                    $values,

                'storedValues' =>
                    $storedValues,
            ]
        );
    }

    /**
     * Update one Settings section.
     */
    public function update(
        UpdateSettingsSectionRequest $request,
        string $section
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Normalize and verify route section
        |--------------------------------------------------------------------------
        */

        $section = strtolower(
            trim($section)
        );

        /*
         * Prevent any inconsistency between the route parameter
         * and the FormRequest section.
         */
        abort_unless(
            $section === $request->section(),
            404
        );

        abort_unless(
            $request->sectionExists(),
            404
        );

        $sectionConfig =
            $request->sectionConfig();

        $fields =
            $request->fields();

        $group =
            $sectionConfig['group']
            ?? $section;

        /*
        |--------------------------------------------------------------------------
        | Validated normal values and uploaded files
        |--------------------------------------------------------------------------
        */

        $normalValues =
            $request->settingsData();

        $uploadedFiles =
            $request->settingsFiles();

        /*
        |--------------------------------------------------------------------------
        | File tracking
        |--------------------------------------------------------------------------
        |
        | New files:
        | Removed if the database save fails.
        |
        | Old files:
        | Removed only after the database transaction succeeds.
        |
        */

        $newFiles = [];

        $oldFilesToDelete = [];

        try {
            /*
            |--------------------------------------------------------------------------
            | Store new uploaded files first
            |--------------------------------------------------------------------------
            */

            foreach (
                $uploadedFiles
                as $key => $uploadedFile
            ) {
                $definition =
                    $fields[$key]
                    ?? null;

                if (!is_array($definition)) {
                    continue;
                }

                $disk =
                    $definition['disk']
                    ?? 'public';

                $directory = trim(
                    (string) (
                        $definition['directory']
                        ?? "settings/{$group}"
                    ),
                    '/'
                );

                /*
                 * Laravel will generate a safe unique filename.
                 */
                $path =
                    $uploadedFile->store(
                        $directory,
                        $disk
                    );

                if ($path === false) {
                    throw new \RuntimeException(
                        "Unable to store Settings file: {$key}"
                    );
                }

                /*
                 * Remember new files in case the database operation fails.
                 */
                $newFiles[] = [
                    'disk' => $disk,
                    'path' => $path,
                ];

                /*
                 * Remember previous file.
                 *
                 * Do not delete it yet.
                 */
                $oldPath =
                    $this->settings->get(
                        "{$group}.{$key}"
                    );

                if (
                    is_string($oldPath) &&
                    $oldPath !== '' &&
                    $oldPath !== $path
                ) {
                    $oldFilesToDelete[] = [
                        'disk' =>
                            $disk,

                        'path' =>
                            $oldPath,

                        'directory' =>
                            $directory,
                    ];
                }

                /*
                 * Add the new file path to the values that
                 * will be saved in system_settings.
                 */
                $normalValues[$key] =
                    $path;
            }

            /*
            |--------------------------------------------------------------------------
            | Save the complete section atomically
            |--------------------------------------------------------------------------
            |
            | The outer transaction ensures that if any setting fails,
            | database changes for this section are rolled back together.
            |
            */

            DB::transaction(
                function () use (
                    $fields,
                    $normalValues,
                    $group
                ): void {
                    foreach (
                        $fields
                        as $key => $definition
                    ) {
                        if (!is_array($definition)) {
                            continue;
                        }

                        /*
                         * Preserve settings that were not submitted.
                         *
                         * This is especially important for image/file
                         * fields when no replacement file is uploaded.
                         */
                        if (
                            !array_key_exists(
                                $key,
                                $normalValues
                            )
                        ) {
                            continue;
                        }

                        $type =
                            strtolower(
                                (string) (
                                    $definition['type']
                                    ?? 'string'
                                )
                            );

                        $isPublic =
                            (bool) (
                                $definition['public']
                                ?? false
                            );

                        $description =
                            $definition['description']
                            ?? null;

                        $this->settings->set(
                            fullKey:
                                "{$group}.{$key}",

                            value:
                                $normalValues[$key],

                            type:
                                $type,

                            isPublic:
                                $isPublic,

                            description:
                                is_string(
                                    $description
                                )
                                    ? $description
                                    : null
                        );
                    }
                }
            );

            /*
            |--------------------------------------------------------------------------
            | Delete replaced old files after successful DB commit
            |--------------------------------------------------------------------------
            */

            foreach (
                $oldFilesToDelete
                as $oldFile
            ) {
                $disk =
                    $oldFile['disk'];

                $path =
                    $oldFile['path'];

                $directory =
                    rtrim(
                        $oldFile['directory'],
                        '/'
                    );

                /*
                 * Safety:
                 * only delete files belonging to this configured
                 * Settings directory.
                 */
                if (
                    !str_starts_with(
                        $path,
                        $directory . '/'
                    )
                ) {
                    continue;
                }

                if (
                    Storage::disk($disk)
                        ->exists($path)
                ) {
                    Storage::disk($disk)
                        ->delete($path);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Ensure latest values are loaded
            |--------------------------------------------------------------------------
            */

            $this->settings->clearCache();

            return back()->with(
                'success',
                __(
                    'messages.settings_updated'
                )
            );
        } catch (Throwable $exception) {
            /*
            |--------------------------------------------------------------------------
            | Clean up newly uploaded files after failure
            |--------------------------------------------------------------------------
            */

            foreach (
                $newFiles
                as $newFile
            ) {
                try {
                    if (
                        Storage::disk(
                            $newFile['disk']
                        )->exists(
                            $newFile['path']
                        )
                    ) {
                        Storage::disk(
                            $newFile['disk']
                        )->delete(
                            $newFile['path']
                        );
                    }
                } catch (Throwable) {
                    /*
                     * Do not hide the original exception
                     * because cleanup itself failed.
                     */
                }
            }

            report(
                $exception
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    __(
                        'messages.settings_update_failed'
                    )
                );
        }
    }
}