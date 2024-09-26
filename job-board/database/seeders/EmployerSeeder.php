<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employerCount = 20;
        $users = User::all()->shuffle();

        for ($i = 0; $i < $employerCount; $i++) 
        {
            Employer::factory()->create([
               'user_id' => $users->pop()->id
            ]);
        }
    }
}
