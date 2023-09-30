<?php

namespace CustomLogCreator\CustomLogging;

use Illuminate\Support\ServiceProvider;

class CustomLoggingServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $serverName = request()->server('SERVER_NAME');
        // Get the folder name and path name from configuration
        $folderName = config('customlogging.folder_name');
        $pathName = config('customlogging.path_name');

        // Construct the log folder path
        $logFolderPath = storage_path('logs/' . ($folderName ? $folderName . '/' : '') . ($pathName ?: $serverName . '_' . php_sapi_name()));

        // Create log folder if it doesn't exist
        if (!file_exists($logFolderPath)) {
            mkdir($logFolderPath, 0755, true); // Create the folder with permissions 0755
        }

        // Configure the custom log channel
        config([
            'logging.channels.dynamic_logs' => [
                'driver' => 'daily',
                'path' => $logFolderPath . '.log', // Removed the extra folder name

                'level' => 'info',
                'tap' => [],
            ],
        ]);



       // s3 logs upload
        if(config('customlogging.is_upload_s3_bucket')) {
            if(config('filesystems.disks.s3.key') && config('filesystems.disks.s3.secret')) {
                $customlog = new CustomLogging;
                $customlog->uploadLog();
            }
        }
       
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/customlogging.php', 'customlogging');

        // Register the service the package provides.
        $this->app->singleton('customlogging', function ($app) {
            return new CustomLogging;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['customlogging'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/customlogging.php' => config_path('customlogging.php'),
        ], 'customlogging');

    }
}

