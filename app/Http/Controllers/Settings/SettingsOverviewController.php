<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Throwable;

class SettingsOverviewController extends Controller
{
    /**
     * Display the Settings Center overview
     * and safe system-health information.
     */
    public function __invoke()
    {
        /*
        |--------------------------------------------------------------------------
        | Database health
        |--------------------------------------------------------------------------
        */

        $databaseConnected = false;
        $databaseName = null;
        $databaseDriver = null;
        $databaseError = null;

        try {
            DB::connection()->getPdo();

            $databaseConnected = true;

            $databaseName = DB::connection()
                ->getDatabaseName();

            $databaseDriver = DB::connection()
                ->getDriverName();
        } catch (Throwable $exception) {
            $databaseError = 'Database connection unavailable.';
        }

        /*
        |--------------------------------------------------------------------------
        | Storage health
        |--------------------------------------------------------------------------
        */

        $storagePath = storage_path();

        $storageWritable = is_dir($storagePath)
            && is_writable($storagePath);

        $freeSpace = null;

        try {
            $bytes = @disk_free_space(
                $storagePath
            );

            if (
                $bytes !== false &&
                is_numeric($bytes)
            ) {
                $freeSpace = $this->formatBytes(
                    (float) $bytes
                );
            }
        } catch (Throwable) {
            $freeSpace = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Safe application information
        |--------------------------------------------------------------------------
        |
        | Do NOT expose:
        |
        | APP_KEY
        | DB_HOST
        | DB_USERNAME
        | DB_PASSWORD
        | MAIL_PASSWORD
        | server credentials
        |
        */

        $health = [

            'application' => [

                'name' => config(
                    'app.name',
                    'EMIS'
                ),

                'environment' => app()->environment(),

                'debug' => (bool) config(
                    'app.debug',
                    false
                ),

                'laravel_version' =>
                    app()->version(),

                'php_version' =>
                    PHP_VERSION,

                'timezone' => config(
                    'app.timezone',
                    'UTC'
                ),

                'locale' =>
                    app()->getLocale(),

                'maintenance_mode' =>
                    app()->isDownForMaintenance(),
            ],

            'database' => [

                'connected' =>
                    $databaseConnected,

                'database' =>
                    $databaseName,

                'driver' =>
                    $databaseDriver,

                'error' =>
                    $databaseError,
            ],

            'storage' => [

                'writable' =>
                    $storageWritable,

                'free_space' =>
                    $freeSpace,
            ],

            'administrator' => [

                'id' =>
                    auth()->id(),

                'name' =>
                    auth()->user()?->name,

                'email' =>
                    auth()->user()?->email,
            ],
        ];

        return view(
            'settings.overview',
            compact('health')
        );
    }

    /**
     * Convert bytes to a readable size.
     */
    private function formatBytes(
        float $bytes,
        int $precision = 2
    ): string {
        $units = [
            'B',
            'KB',
            'MB',
            'GB',
            'TB',
        ];

        $bytes = max(
            $bytes,
            0
        );

        if ($bytes === 0.0) {
            return '0 B';
        }

        $power = min(
            (int) floor(
                log(
                    $bytes,
                    1024
                )
            ),
            count($units) - 1
        );

        $value = $bytes
            / (1024 ** $power);

        return round(
            $value,
            $precision
        ) . ' ' . $units[$power];
    }
}