<?php

namespace modules\Permission\Providers;

use Carbon\Laravel\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function register(){}
    public function boot(){
        $this->loadRoutesFrom(app_path(__DIR__.'./../Routes/permission_api_routes.php'));
        $this->loadMigrationsFrom(app_path(__DIR__.'./../Database/Migrations'));
    }

}
