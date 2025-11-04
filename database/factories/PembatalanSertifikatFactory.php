<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PembatalanSertifikat>
 */
class PembatalanSertifikatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenis = ['Bangunan', 'Tanah', 'Kendaraan', 'Peralatan'];
        $status = ['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan'];

        return [
            'no_sertifikat'     => 'SRT-' . $this->faker->year() . '-' . str_pad($this->faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT),
            'pemilik'           => $this->faker->name(),
            'lokasi'            => $this->faker->city(),
            'jenis'             => $this->faker->randomElement($jenis),
            'status'            => $this->faker->randomElement($status),
            'penanggung_jawab'  => $this->faker->name(),
            'target_selesai'    => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
        ];
    }
}
