<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketStatusLog;

class TicketStatusLogSeeder extends Seeder
{
    public function run(): void
    {
        TicketStatusLog::factory(50)->create();
    }
}