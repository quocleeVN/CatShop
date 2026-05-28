<?php

namespace App\Providers;

use App\Support\WindowsSafeFilesystem;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (windows_os()) {
            $this->app->singleton('files', fn() => new WindowsSafeFilesystem());
            $this->app->alias('files', Filesystem::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('testing')) {
            $compiledPath = storage_path('framework/testing/views');

            File::ensureDirectoryExists($compiledPath);

            config(['view.compiled' => $compiledPath]);
        }
    }
}
