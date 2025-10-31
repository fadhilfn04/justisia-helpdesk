<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketTimeline;

class TicketTimelineSeeder extends Seeder
{
    public function run(): void
    {
        TicketTimeline::factory(50)->create();
    }
}