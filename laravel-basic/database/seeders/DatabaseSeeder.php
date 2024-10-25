<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        if ($this->command->confirm('Do you wanto Seed the database?')) {

            Cache::tags(['blog-post'])->flush();

            $this->call([
                UserSeeder::class,
                BlogPostSeeder::class,
                CommentSeeder::class,
                TagSeeder::class                
            ]);

            $this->command->info('Database Successfully Seeded!');
        }
    }
}
