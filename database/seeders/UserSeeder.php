<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()
            ->withPersonalTeam()
            ->create([
                'name' => 'Test',
                'email' => 'test@example.com',
            ]);
    }
}
