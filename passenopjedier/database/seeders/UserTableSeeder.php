<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Making a Admin
        User::create([
            'name' => 'Annick (Admin)',
            'email' => 'annick@example.com',
            'password' => env('ADMIN_PASSWORD'),
            'role' => true, //Admin role
        ]);
    }
}
