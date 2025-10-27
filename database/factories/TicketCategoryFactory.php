<?php

namespace Database\Factories;

use App\Models\TicketCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketCategoryFactory extends Factory
{
    protected $model = TicketCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Masalah Teknis',
                'Tagihan & Pembayaran',
                'Permintaan Fitur',
                'Pertanyaan Umum',
                'Akses Akun'
            ]),
            'description' => $this->faker->sentence(10, true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}