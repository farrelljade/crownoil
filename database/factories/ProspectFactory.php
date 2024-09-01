<?php

namespace Database\Factories;

use App\Models\LeadSource;
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
            'user_id' => User::inRandomOrder()->first()->id,
            'contact_name' => $this->faker->name(),
            'number' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'lead_source_id' => LeadSource::inRandomOrder()->first()->id ?? LeadSource::factory()->create()->id,
        ];
    }
}
