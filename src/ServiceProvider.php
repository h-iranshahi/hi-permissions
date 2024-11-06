<?php

namespace Iransh\HiPermissions;

use Illuminate\Support\ServiceProvider as SP;
use Iransh\HiPermissions\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class ServiceProvider extends SP
{
    public function boot()
    {
        // Load Migrations
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        // Publish config
        $this->publishes([
            __DIR__.'/config/hi_permissions.php' => config_path('hi_permissions.php'),
        ], 'config');
    }

    public function register()
    {
        // Register Middleware if needed
        $this->mergeConfigFrom(
            __DIR__.'/config/hi_permissions.php','hi_permissions'
        );

        //
        if (Schema::hasTable(config('hi_permissions.permissions_table', 'permissions'))) {
            // Use query builder to get permissions to avoid Eloquent dependency issues
            $permissions = DB::table(config('hi_permissions.permissions_table', 'permissions'))->get();
        
            $permissions->map(function ($permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasAccess($permission);
                });
            });
        }

    }
}
