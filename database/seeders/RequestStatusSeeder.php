<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => '접수', 'color' => '#00BD44', 'order' => 1],
            ['name' => '공수확인요청', 'color' => '#6C4EE2', 'order' => 2],
            ['name' => '공수확인완료', 'color' => '#373F57', 'order' => 3],
            ['name' => '진행중', 'color' => '#1466D6', 'order' => 4],
            ['name' => '재요청', 'color' => '#FB0E55', 'order' => 5],
            ['name' => '완료', 'color' => '#373F57', 'order' => 6],
        ];

        foreach ($statuses as $status) {
            DB::table('request_statuses')->insert([
                'name' => $status['name'],
                'color' => $status['color'],
                'order' => $status['order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
