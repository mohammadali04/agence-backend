<?php

namespace Modules\Identity\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Identity\Models\User;

class UserSeeder extends Seeder
{
    public function run() {
        User::factory(3)->create();
    }

}
