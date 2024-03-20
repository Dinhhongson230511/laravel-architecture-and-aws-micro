<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
        ]);
        Role::create([
            'name' => 'Editor',
        ]);
        Role::create([
            'name' => 'Viewer',
        ]);
    }
}
