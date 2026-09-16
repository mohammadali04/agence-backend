<?php

namespace Database\Seeders;

use Database\Factories\RolePermissionSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Home\Models\Blog;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $this->app->make('Factory')->load(base_path('modules/Home/Database/Factories'));
        $this->call([
//            FeaturesSeeder::class,
//        UserSeeder::class,
        RolePermissionSeeder::class,
        ]);
        // User::factory(10)->create();
    }
}
