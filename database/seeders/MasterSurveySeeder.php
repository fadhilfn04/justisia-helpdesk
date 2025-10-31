<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterSurvey;

class MasterSurveySeeder extends Seeder
{
    public function run(): void
    {
        MasterSurvey::insert([
            ['pertanyaan' => 'Bagaimana kepuasan Anda terhadap layanan kami?'],
            ['pertanyaan' => 'Apakah masalah Anda terselesaikan dengan baik?'],
        ]);
    }
}