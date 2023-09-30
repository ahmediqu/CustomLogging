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
        
        config([
            'logging.channels.dynamic_logs' => [
                'driver' => 'daily',
                'path' => storage_path('logs/' .
                (config('customlogging.is_folder') ? config('customlogging.folder_name').'/' : '') .
                (config('customlogging.path_name') ?: $serverName.'_'.php_sapi_name()).'.log'),

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

