<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => '콘텐츠 수정', 'description' => '웹사이트 콘텐츠 수정 요청'],
            ['name' => '오류발생', 'description' => '웹사이트 오류 수정 요청'],
            ['name' => '메일, 뉴스레터 발송', 'description' => '이메일 발송 요청'],
            ['name' => 'SSL(보안인증서)', 'description' => 'SSL 인증서 관련 요청'],
            ['name' => '도메인 관리', 'description' => '도메인 관련 요청'],
            ['name' => '호스팅 관리', 'description' => '호스팅 관련 요청'],
            ['name' => '기타', 'description' => '기타 유지보수 요청'],
        ];

        foreach ($types as $type) {
            DB::table('maintenance_types')->insert([
                'name' => $type['name'],
                'description' => $type['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
