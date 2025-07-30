<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // make sure this is your custom Role model

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin',         'display_name' => 'Administrator']);
        Role::create(['name' => 'branch_admin',  'display_name' => 'Branch Admin']);
        Role::create(['name' => 'country_admin', 'display_name' => 'Country Admin']);
        Role::create(['name' => 'user',          'display_name' => 'Regular User']);
    }
}

