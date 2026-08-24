<?php
namespace Modules\Identity\Providers;
use Illuminate\Support\ServiceProvider;
class IdentityServiceProvider extends ServiceProvider {
    public function boot() {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/identity_api_routes.php');
    }
}
