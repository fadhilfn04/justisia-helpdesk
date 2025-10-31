<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterSla;

class MasterSlaSeeder extends Seeder
{
    public function run(): void
    {
        MasterSla::insert([
            ['prioritas' => 'Tinggi', 'category_id' => 1],
            ['prioritas' => 'Sedang', 'category_id' => 2],
            ['prioritas' => 'Rendah', 'category_id' => 3],
        ]);
    }
}