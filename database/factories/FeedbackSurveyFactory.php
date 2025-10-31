<?php

namespace Database\Factories;

use App\Models\FeedbackSurvey;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackSurveyFactory extends Factory
{
    protected $model = FeedbackSurvey::class;

    public function definition(): array
    {
        $ratings = [
            1 => 'Sangat tidak puas',
            2 => 'Tidak puas',
            3 => 'Cukup puas',
            4 => 'Puas',
            5 => 'Sangat puas'
        ];

        $rating = $this->faker->numberBetween(1, 5);

        return [
            'ticket_id' => Ticket::inRandomOrder()->first()?->id ?? Ticket::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'rating' => $rating,
            'comment' => "Saya merasa {$ratings[$rating]} dengan layanan yang diberikan.",
            'sent_via' => $this->faker->randomElement(['email', 'whatsapp', 'in-app']),
            'created_at' => now(),
        ];
    }
}