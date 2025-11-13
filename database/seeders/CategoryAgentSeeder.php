<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CategoryAgent;
use Illuminate\Support\Carbon;

class CategoryAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Teknis', 'Akun', 'Lainnya'];
        $now = Carbon::now();
        $agents = User::where('role_id', 2)->get();

        foreach ($agents as $agent) {
            CategoryAgent::create([
                'user_id' => $agent->id,
                'category' => $categories[array_rand($categories)],
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]);
        }
    }
}
