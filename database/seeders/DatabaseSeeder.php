<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UsersSeeder::class,
            TicketCategorySeeder::class,
            FaqSeeder::class,
            MasterSlaSeeder::class,
            MasterSurveySeeder::class,
            TicketSeeder::class,
            TicketMessageSeeder::class,
            TicketStatusLogSeeder::class,
            TicketTimelineSeeder::class,
            FeedbackSurveySeeder::class,
            NotificationSeeder::class,
        ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Ticket::factory(15)
            ->has(\App\Models\TicketStatusLog::factory()->count(2), 'statusLogs')
            ->has(\App\Models\TicketTimeline::factory()->count(3), 'timelines')
            ->has(\App\Models\FeedbackSurvey::factory()->count(1), 'feedbackSurveys')
            ->create();

        \App\Models\Notification::factory(20)->create();
    }
}