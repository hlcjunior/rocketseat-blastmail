<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\EmailList;
use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'subject' => fake()->words(3, true),
            'email_list_id' => EmailList::factory(),
            'template_id' => Template::factory(),
            'track_click' => fake()->boolean(),
            'track_open' => fake()->boolean(),
            'body' => fake()->randomHtml(),
            'created_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'deleted_at' => fake()->boolean ? fake()->dateTimeBetween('-1 week', 'now') : null,
        ];
    }
}
