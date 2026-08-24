<?php
namespace Modules\Blog\Providers;
use Illuminate\Support\ServiceProvider;
class BlogServiceProvider extends ServiceProvider {
    public function boot() {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/blog_api_routes.php');
//        $this->app->make('Factory')->load(__DIR__.'/../Database/Factories');
    }
}
