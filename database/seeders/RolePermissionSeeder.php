<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::get();
        $admin = Role::where('name', 'Admin')->first();

        foreach ($permissions as $permission) {
            RolePermission::insert([
                ['role_id' => $admin->id, 'permission_id' => $permission->id],
            ]);
        }

        $editor = Role::where('name', 'Editor')->first();

        foreach ($permissions as $permission) {
            if(!in_array($permission->name, ['edit_roles'])) {
                RolePermission::insert([
                    ['role_id' => $editor->id, 'permission_id' => $permission->id],
                ]);
            }
        }

        $viewer = Role::where('name', 'Viewer')->first();

        $viewerRoles = [
            'view_users',
            'view_roles',
            'view_products',
            'view_orders',
        ];

        foreach ($permissions as $permission) {
            if(in_array($permission->name, $viewerRoles)) {
                RolePermission::insert([
                    ['role_id' => $viewer->id, 'permission_id' => $permission->id],
                ]);
            }
        }
    }
}
