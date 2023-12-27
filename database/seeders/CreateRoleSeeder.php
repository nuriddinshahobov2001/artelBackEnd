<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin'
        ]);
        Role::create([
            'name' => 'consultant'
        ]);

        User::create([
            'name' => 'manager',
            'phone' => '987654321',
            'password' => Hash::make('password'),
            'email' => 'consultant@gmail.com'
        ])->assignRole('consultant');

    }
}
