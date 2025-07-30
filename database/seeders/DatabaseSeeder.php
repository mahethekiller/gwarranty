<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Run role seeder first
        $this->call([
            RolesSeeder::class,
        ]);

        // Create and assign one user per role
        $roles = Role::all();

        foreach ($roles as $role) {
            User::create([
                'name'     => ucfirst(str_replace('_', ' ', $role->name)) . ' User',
                'email'    => $role->name . '@example.com',
                'password' => Hash::make('password'),
            ])->assignRole($role->name);
        }

        Artisan::call('import:branch-emails');
    }
}
