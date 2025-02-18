<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createRoles();

        $this->createAbilities();
    }

    private function createRoles()
    {
        $roles = collect([
            ["name" => "admin"]
        ]);

        $roles->each(fn($role) => Bouncer::role()->updateOrCreate([
            "name" => $role["name"]
        ], $role));

        Bouncer::allow("admin")->everything();
    }

    private function createAbilities()
    {
        $abilities = collect([
            [
                "name" => "me.access",
                "description" => "Permite al usuario ver la vista de me"
            ]
        ]);

        $abilities->each(fn($ability) => Bouncer::ability()->updateOrCreate([
            "name" => $ability["name"]
        ], $ability));
    }
}
