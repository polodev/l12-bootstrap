<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(['email' => 'polodev10@gmail.com'], [
            'name' => 'Admin User',
            'password' => bcrypt('hello123$$'),
            'role' => 'admin'
        ]);

       
    }
}