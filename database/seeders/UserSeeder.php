<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ])->assignRole('Admin');

        User::create([
            'name' => 'Jiha',
            'email' => 'jiha@customer.com',
            'password' => Hash::make('jiha'),
        ])->assignRole('Customer');
    }
}
