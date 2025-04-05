<?php

namespace Database\Seeders;

use App\Models\EmailList;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        EmailList::factory()->count(10)->create()
            ->each(function (EmailList $emailList) {
                Subscriber::factory()
                    ->count(rand(3, 20))
                    ->create(['email_list_id' => $emailList->id]);
            });
    }
}
