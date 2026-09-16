<?php

namespace Database\Factories;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // تعریف permissions
        $permissions = [
            'create-article',
            'edit-article',
            'delete-article',
            'view-article',
            'create-user',
            'edit-user',
            'delete-user',
            'view-user',
            'create-role',
            'edit-role',
            'delete-role',
            'view-role',
            'create-permission',
            'edit-permission',
            'delete-permission',
            'view-permission',
            'create-feature',
            'edit-feature',
            'delete-feature',
            'view-feature',
            'create-article-category',
            'edit-article-category',
            'delete-article-category',
            'view-article-category',
        ];
        $permissions_array = [];
        foreach ($permissions as $perm) {
           $permission = Permission::create(['name' => $perm,'guard_name' => 'api']);
           $permissions_array[] = $permission;
        }

        // ساخت نقش‌ها و assign permissions
        $admin = Role::create(['name' => 'admin','guard_name' => 'api']);
        foreach ($permissions_array as $perm) {
            $perm->assignRole($admin);
        }


        $editor = Role::create(['name' => 'editor','guard_name' => 'api']);
        $editor->givePermissionTo(['create-article', 'edit-article', 'view-article']);
    }
}
