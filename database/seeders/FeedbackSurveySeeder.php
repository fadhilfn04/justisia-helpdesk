<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeedbackSurvey;

class FeedbackSurveySeeder extends Seeder
{
    public function run(): void
    {
        FeedbackSurvey::factory(10)->create();
    }
}