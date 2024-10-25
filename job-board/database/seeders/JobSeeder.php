<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobsCount = 100;

        $employer = Employer::all();

        for ($i = 0; $i < $jobsCount; $i++) 
        {
            Job::factory()->create([
                'employer_id' => $employer->random()->id
            ]);
        }
    }
}
