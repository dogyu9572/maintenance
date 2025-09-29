<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 기본 관리자 계정들
        $this->createBasicUsers();
        
        // 테스트용 사용자들 (클라이언트가 있는 경우에만)
        $this->createTestUsers();
    }

    private function createBasicUsers(): void
    {
        // 홈페이지코리아 관리자 계정
        User::create([
            'name' => '홈페이지코리아',
            'login_id' => 'homepage',
            'email' => 'admin@homepagekorea.com',
            'password' => Hash::make('homepagekorea'),
            'is_admin' => true,
            'position' => '관리자',
            'is_active' => true,
        ]);

        // 기존 테스트 계정들
        User::create([
            'name' => '강심장',
            'login_id' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'position' => '국장',
            'is_active' => true,
        ]);

        User::create([
            'name' => '박은지',
            'login_id' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'position' => '대리',
            'is_active' => true,
        ]);
    }

    private function createTestUsers(): void
    {
        // 테스트용 클라이언트 사용자들 생성

        $names = [
            '삼성전자', 'LG전자', '현대자동차', 'SK하이닉스', '포스코',
            'KT', 'SK텔레콤', '네이버', '카카오', '쿠팡',
            '배달의민족', '토스', '당근마켓', '무신사', '스타벅스',
            '롯데마트', '이마트', '홈플러스', '올리브영', '올리브네트웍스',
            '신세계', '롯데백화점', '현대백화점', '갤러리아', '타임스퀘어',
            '코엑스몰', 'IFC몰', '롯데월드타워', '63빌딩', 'N서울타워'
        ];

        $positions = ['과장', '대리', '사원', '팀장', '부장', '차장', '주임', '선임'];
        $accountTypes = ['new', 'renewal'];

        for ($i = 1; $i <= 30; $i++) {
            $name = $names[$i - 1];
            $loginId = 'test' . str_pad($i, 2, '0', STR_PAD_LEFT);
            
            User::create([
                'name' => $name,
                'login_id' => $loginId,
                'email' => $loginId . '@example.com',
                'password' => Hash::make('password123'),
                'phone' => '010-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
                'client_type' => ['association', 'company', 'individual'][array_rand(['association', 'company', 'individual'])],
                'position' => $positions[array_rand($positions)],
                'contract_start' => '2024-01-01',
                'contract_end' => '2024-12-31',
                'is_admin' => false,
                'is_active' => true,
                'account_type' => $accountTypes[array_rand($accountTypes)],
                'created_at' => now()->subDays(rand(1, 365)),
                'updated_at' => now()->subDays(rand(1, 365)),
            ]);
        }

        $this->command->info('테스트용 사용자 30개가 생성되었습니다.');
    }
}
