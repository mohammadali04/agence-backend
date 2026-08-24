<?php
namespace Modules\Shared\Providers;
use Illuminate\Support\ServiceProvider;
class SharedServiceProvider extends ServiceProvider {
    public function boot() {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/shared_api_routes.php');
    }
}
