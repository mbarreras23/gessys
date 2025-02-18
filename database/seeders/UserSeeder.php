<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = collect([
            [
                "email" => "admin@test.com.mx",
                "name" => "Manuel",
                "surname" => "Barreras",
                "second_surname" => "Soto",
                "password" => Hash::make("laravel_123"),
                "role" => "admin"
            ],
        ]);

        $users->each(function ($user) {
            $new_user = User::updateOrCreate(
                [
                    "email" => $user["email"]
                ],
                [
                    "name" => $user["name"],
                    "surname" => $user["surname"],
                    "second_surname" => $user["second_surname"],
                    "password" => $user["password"]
                ]
            );

            $new_user->assign($user["role"]);
        });
    }
}
