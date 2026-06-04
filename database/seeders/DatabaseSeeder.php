<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run admin seeder first
        $this->call(AdminUserSeeder::class);

        // Create test employees
        User::factory(10)->create([
            'role' => 'employee',
        ]);
    }
}
