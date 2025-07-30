<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'talentgroup.id@gmail.com',
            'email_verified_at' => now(),
            'role_id' => 1,
            'balance' => 0,
            'password' => Hash::make('password1234'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}