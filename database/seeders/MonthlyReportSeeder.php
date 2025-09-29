<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MonthlyReport;
use App\Models\User;
use Carbon\Carbon;

class MonthlyReportSeeder extends Seeder
{
    public function run(): void
    {
        // 일반 사용자(클라이언트)만 가져오기
        $clients = User::where('is_admin', false)                      
                      ->where('is_active', true)
                      ->get();

        if ($clients->isEmpty()) {
            $this->command->info('클라이언트 사용자 데이터가 없어 월간보고서 생성을 건너뜁니다.');
            return;
        }

        $nowYear = now()->year;
        $months = range(1, 12);

        // 최근 6개월치 무작위 클라이언트로 생성
        $count = 0;
        foreach (array_slice(array_reverse($months), 0, 6) as $month) {
            $client = $clients->random();
            
            // 중복 방지
            $exists = MonthlyReport::where('client_id', $client->idx)
                ->where('year', $nowYear)
                ->where('month', $month)
                ->exists();
                
            if ($exists) { 
                continue; 
            }

            // 업무기간 설정 (해당 월의 1일부터 마지막 날까지)
            $workStartDate = Carbon::create($nowYear, $month, 1);
            $workEndDate = $workStartDate->copy()->endOfMonth();

            MonthlyReport::create([
                'user_id' => $client->idx, // 작성자
                'client_id' => $client->idx, // 클라이언트 ID (user_id와 동일)
                'year' => $nowYear,
                'month' => $month,
                'title' => sprintf('%d년 %d월 업무현황보고서', $nowYear, $month),
                'content' => $this->generateReportContent($nowYear, $month, $client),
                'status' => 'published',
                'is_published' => true,
                'work_start_date' => $workStartDate,
                'work_end_date' => $workEndDate,
                'project_name' => $client->domain ? $client->domain . ' 유지보수' : '웹사이트 유지보수',
                'manager_name' => $client->manager_name ?: $client->name,
                'company_name' => $client->name,
                'created_at' => $workEndDate,
                'updated_at' => $workEndDate,
            ]);
            $count++;
        }

        $this->command->info("월간보고서 더미 데이터 {$count}건이 생성되었습니다.");
    }

    /**
     * 보고서 내용 생성
     */
    private function generateReportContent(int $year, int $month, User $client): string
    {
        $monthNames = [
            1 => '1월', 2 => '2월', 3 => '3월', 4 => '4월', 5 => '5월', 6 => '6월',
            7 => '7월', 8 => '8월', 9 => '9월', 10 => '10월', 11 => '11월', 12 => '12월'
        ];

        $content = "{$year}년 {$monthNames[$month]} 업무현황보고서\n\n";
        $content .= "고객사: {$client->name}\n";
        $content .= "보고기간: {$year}년 {$monthNames[$month]} 1일 ~ {$monthNames[$month]} 말일\n\n";
        
        $content .= "1. 주요 업무 내용\n";
        $content .= "- 웹사이트 정기 점검 및 모니터링\n";
        $content .= "- 보안 업데이트 및 패치 적용\n";
        $content .= "- 백업 데이터 검증 및 복구 테스트\n";
        $content .= "- 사용자 문의 응대 및 기술 지원\n\n";
        
        $content .= "2. 시스템 현황\n";
        $content .= "- 서버 상태: 정상\n";
        $content .= "- 데이터베이스: 정상\n";
        $content .= "- 웹 애플리케이션: 정상\n\n";
        
        $content .= "3. 특이사항\n";
        $content .= "- 특별한 문제 없이 안정적으로 운영됨\n";
        $content .= "- 정기 백업 완료\n\n";
        
        $content .= "4. 다음 달 계획\n";
        $content .= "- 정기 점검 및 모니터링 계속\n";
        $content .= "- 필요시 보안 업데이트 진행\n";
        
        return $content;
    }
}


