<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Kevin",
            "email" => "kevin@ennovateventures.co",
            "password" => Hash::make("Test1234!")
           ]);

           User::create([
            "name" => "Devotha",
            "email" => "devotha@ennovateventures.co",
            "password" => Hash::make("Test1234!")
           ]);
    }
}
