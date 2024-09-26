<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $recordCount = 500;

        for ($i=0; $i<$recordCount; $i++)
        {
            $user = $users->random();
            Event::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
