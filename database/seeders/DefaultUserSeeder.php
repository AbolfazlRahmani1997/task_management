<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Admin User
        $admin = User::create([
            'name' => 'abolfazl',
            'email' => 'abolfazl@gmail.com',
            'password' => Hash::make('abolfazl1234')
        ]);
        $admin->assignRole('admin');
        $permissions = [
            'view-user',
            'create-user',
            'edit-user',
            'delete-user',
            'create-task',
            'edit-task',
            'delete-task',
            'view-task',
        ];
        $admin->givePermissionTo($permissions);
        // Creating Application User
        $user = User::create([
            'name' => 'Ali',
            'email' => 'Ali@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $user->assignRole('user');
    }
}
