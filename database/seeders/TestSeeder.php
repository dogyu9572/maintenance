<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('테스트 시더가 실행되었습니다!');
        $this->command->info('현재 시간: ' . now());
    }
}
