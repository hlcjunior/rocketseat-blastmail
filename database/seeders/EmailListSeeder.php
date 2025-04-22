<?php

namespace Database\Seeders;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailList::factory()->count(10)->create()
            ->each(function (EmailList $emailList) {
                Subscriber::factory()
                    ->count(rand(3, 20))
                    ->create(['email_list_id' => $emailList->id]);
            });
    }
}
