<?php
namespace Modules\Home\Providers;
use Illuminate\Support\ServiceProvider;
class HomeServiceProvider extends ServiceProvider {
    public function boot() {
        $this->loadRoutesFrom(__DIR__.'/../Routes/home_api_routes.php');
//        $this->app->make('Factory')->load(__DIR__.'/../Database/Factories');
    }
}
