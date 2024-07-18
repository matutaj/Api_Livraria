<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where('email', 'matutajorge@gmail.com')->first()){
            User::create([
            'name' => 'Matuta Jorge',
            'email' =>'matutajorge@gmail.com',
            'password' => Hash::make('12345678a', ['rounds'=> 12]),
            ]);
        };
    
    }
}
