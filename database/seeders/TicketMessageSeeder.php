<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketMessage;

class TicketMessageSeeder extends Seeder
{
    public function run(): void
    {
        TicketMessage::factory(50)->create();
    }
}