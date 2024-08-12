<?php

namespace Database\Factories;

use App\Enums\LeadSource;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prospect>
 */
class ProspectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'lead_source' => $this->faker->randomElement([
                LeadSource::OUTBOUND_PROSPECT_CALL,
                LeadSource::INBOUND_REFERRAL,
                LeadSource::INBOUND_WEBSITE,
                LeadSource::LIVE_CHAT,
            ]),
            'assigned_user' => User::inRandomOrder()->first()->id,
            'contact_name' => $this->faker->name,
            'line_1' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'postcode' => $this->faker->postcode(),
            'number' => $this->faker->phoneNumber(),
            'email' => $this->faker->email()
        ];
    }
}
