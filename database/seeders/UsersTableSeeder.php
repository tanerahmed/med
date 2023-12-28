<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // author
            [
                'name' => "Author",
                'email' => 'author@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'status' => 'active',
            ],
            // reviewer
            [
                'name' => "Reviewer",
                'email' => 'reviewer@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'reviewer',
                'status' => 'active',
            ],
            // editor
            [
                'name' => "Editor",
                'email' => 'editor@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'editor',
                'status' => 'active',
            ],
            // admin
            [
                'name' => "Admin",
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'status' => 'active',
            ],
            // user
            [
                'name' => "User",
                'email' => 'user@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'user',
                'status' => 'active',
            ]
            ]);
    }
}
