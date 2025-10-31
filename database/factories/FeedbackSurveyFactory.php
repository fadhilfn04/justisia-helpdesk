<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use App\Models\MasterSurvey;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackSurveyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'user_id' => User::factory(),
            'survey_id' => $this->faker->optional()->randomElement(MasterSurvey::pluck('id')->toArray() ?: [null]),
            'nilai' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->optional()->sentence(8),
            'sent_via' => $this->faker->randomElement(['email', 'sms', 'whatsapp', 'web']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}