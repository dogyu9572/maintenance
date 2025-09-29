<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notice;
use App\Models\User;

class NoticeSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('idx')->toArray();
        if (empty($userIds)) {
            $this->command->info('사용자 데이터가 없어 공지사항 생성을 건너뜁니다.');
            return;
        }

        $this->createBasicNotices($userIds);
        $this->createTestNotices($userIds);
    }

    private function createBasicNotices(array $userIds): void
    {
        // 상단 고정(중요) 공지 1건
        Notice::create([
            'user_id' => $userIds[array_rand($userIds)],
            'title' => '서비스 점검 안내 (오늘 23:00~24:00)',
            'content' => '안정적인 서비스 제공을 위해 오늘 23시부터 24시까지 서버 점검을 진행합니다. 이용에 불편을 드려 죄송합니다.',
            'is_important' => true,
        ]);
    }

    private function createTestNotices(array $userIds): void
    {
        $titles = [
            '신규 기능 출시 안내',
            '보안 업데이트 적용 안내',
            '서비스 이용약관 변경 공지',
            '정기 점검 일정 안내',
            '문의 응대 시간 변경 안내',
            '모바일 앱 업데이트 안내',
            '긴급 패치 적용 안내',
            '데이터 백업 완료 안내',
            '신규 고객사 환영 이벤트',
            '장애 복구 완료 안내',
        ];

        for ($i = 0; $i < 30; $i++) {
            Notice::create([
                'user_id' => $userIds[array_rand($userIds)],
                'title' => $titles[$i % count($titles)],
                'content' => '상세 내용은 관리자 페이지에서 확인해 주세요. 감사합니다.',
                'is_important' => false,
                'created_at' => now()->subDays(rand(0, 60)),
                'updated_at' => now()->subDays(rand(0, 60)),
            ]);
        }
        $this->command->info('공지사항 더미 데이터 31건(중요 1건 포함)이 생성되었습니다.');
    }
}


