<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'super_admin',
            'email' => 'admin@upwork.com',
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(10)
        ]);
    }
}
