<?php

namespace Database\Seeders;

use App\Models\PembatalanSertifikat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembatalanSertifikatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PembatalanSertifikat::factory(50)->create();
    }
}
