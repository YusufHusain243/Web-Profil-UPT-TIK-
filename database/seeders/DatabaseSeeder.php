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
        User::factory()->create([
            'name' => 'Admin UPA TIK',
            'email' => 'tik@upr.ac.id',
            'password' => 'Admin@UPR2026!',
            'email_verified_at' => now(),
        ]);
    }
}
