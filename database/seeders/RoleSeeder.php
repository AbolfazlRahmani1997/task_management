<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        $admin->givePermissionTo([
            'view-user',
            'create-user',
            'edit-user',
            'delete-user',
            'create-task',
            'edit-task',
            'delete-task'
        ]);
        $user->givePermissionTo([
            'view-task',
            'create-task',
            'edit-task',
            'delete-task'
        ]);


    }
}
