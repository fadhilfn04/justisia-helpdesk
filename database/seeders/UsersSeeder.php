<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin JUSTISIA',
            'email' => 'admin@justisia.test',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'phone' => '081234567890'
        ]);

        User::create([
            'name' => 'Agent Support',
            'email' => 'agent@justisia.test',
            'password' => Hash::make('password'),
            'role_id' => 2,
            'phone' => '081298765432'
        ]);

        User::factory(20)->create();
    }
}