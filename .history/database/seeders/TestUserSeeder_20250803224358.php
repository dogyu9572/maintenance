<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        // 클라이언트 ID 가져오기
        $clientIds = Client::pluck('idx')->toArray();
        
        if (empty($clientIds)) {
            $this->command->error('클라이언트 데이터가 없습니다. ClientSeeder를 먼저 실행해주세요.');
            return;
        }

        $names = [
            '김철수', '이영희', '박민수', '정수진', '최동욱',
            '한지영', '윤성호', '임미영', '송태호', '강지은',
            '조현우', '신혜진', '오승철', '류민지', '백준호',
            '남궁영', '전유진', '고민수', '양지혜', '문성호',
            '구미영', '배준호', '손지은', '안현우', '차혜진',
            '홍승철', '유민지', '서준호', '노지은', '하현우'
        ];

        $positions = ['과장', '대리', '사원', '팀장', '부장', '차장', '주임', '선임'];
        $types = ['신규', '기존', 'VIP'];

        for ($i = 1; $i <= 30; $i++) {
            $name = $names[$i - 1];
            $loginId = 'test' . str_pad($i, 2, '0', STR_PAD_LEFT);
            
            User::create([
                'name' => $name,
                'login_id' => $loginId,
                'email' => $loginId . '@example.com',
                'password' => Hash::make('password123'),
                'phone' => '010-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
                'client_id' => $clientIds[array_rand($clientIds)],
                'position' => $positions[array_rand($positions)],
                'contract_start' => '2024-01-01',
                'contract_end' => '2024-12-31',
                'is_admin' => false,
                'is_active' => true,
                'type' => $types[array_rand($types)],
                'created_at' => now()->subDays(rand(1, 365)),
                'updated_at' => now()->subDays(rand(1, 365)),
            ]);
        }

        $this->command->info('테스트용 사용자 30개가 생성되었습니다.');
    }
} 