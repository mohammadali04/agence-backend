<?php

namespace modules\Permission\Providers;

use Carbon\Laravel\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function register(){}
    public function boot(){
        $this->loadRoutesFrom(__DIR__.'/../Routes/permission_api_routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

}
