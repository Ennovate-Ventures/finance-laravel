<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MobileUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Ekene",
            "email" => "ekene@ennovateventures.co",
            "password" => Hash::make("Test1234!")
        ]);

        User::create([
            "name" => "Jasmine",
            "email" => "jasmin@ennovateventures.co",
            "password" => Hash::make("Test1234!")
        ]);
    }
}
