<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceRequest;
use App\Models\User;
use App\Models\MaintenanceType;
use App\Models\RequestStatus;

class SimpleMaintenanceRequestSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('간단한 유지보수 요청 시더 시작');
        
        // 기본 데이터 확인
        $user = User::where('is_admin', false)->first();
        $adminUser = User::where('is_admin', true)->first();
        $type = MaintenanceType::first();
        $status = RequestStatus::first();
        
        if (!$user || !$adminUser || !$type || !$status) {
            $this->command->error('필요한 기본 데이터가 없습니다.');
            return;
        }
        
        $this->command->info("사용자: {$user->name}");
        $this->command->info("관리자: {$adminUser->name}");
        $this->command->info("타입: {$type->name}");
        $this->command->info("상태: {$status->name}");
        
        try {
            // 다양한 고객사의 유지보수 요청들 생성
            $requests = [
                [
                    'title' => '네이버 쇼핑몰 상품 등록 페이지 오류 수정',
                    'content' => '네이버 쇼핑몰의 상품 등록 페이지에서 이미지 업로드 시 발생하는 오류를 수정해주세요. 특정 브라우저에서만 발생하는 문제입니다.',
                    'status_id' => 1, // 접수
                    'request_date' => now()->subDays(5)->toDateString(),
                    'expected_date' => now()->addDays(3)->toDateString(),
                ],
                [
                    'title' => 'KT 통신사 고객센터 FAQ 페이지 콘텐츠 업데이트',
                    'content' => 'KT 통신사 고객센터 FAQ 페이지의 최신 서비스 관련 질문과 답변을 추가하고, 기존 내용을 최신화해주세요.',
                    'status_id' => 4, // 진행중
                    'request_date' => now()->subDays(3)->toDateString(),
                    'expected_date' => now()->addDays(1)->toDateString(),
                ],
                [
                    'title' => '올리브영 온라인몰 결제 시스템 보안 강화',
                    'content' => '올리브영 온라인몰의 결제 시스템 보안을 강화해주세요. SSL 인증서 갱신과 결제 페이지 보안 검증이 필요합니다.',
                    'status_id' => 2, // 공수확인요청
                    'request_date' => now()->subDays(2)->toDateString(),
                    'expected_date' => now()->addDays(5)->toDateString(),
                ],
                [
                    'title' => '당근마켓 중고거래 게시판 모바일 반응형 개선',
                    'content' => '당근마켓 중고거래 게시판의 모바일 반응형을 개선해주세요. 다양한 디바이스에서 원활하게 작동하도록 수정이 필요합니다.',
                    'status_id' => 3, // 공수확인완료
                    'request_date' => now()->subDays(1)->toDateString(),
                    'expected_date' => now()->addDays(7)->toDateString(),
                ],
                [
                    'title' => '카카오뱅크 모바일앱 로그인 페이지 디자인 개선',
                    'content' => '카카오뱅크 모바일앱의 로그인 페이지 디자인을 현대적으로 개선해주세요. 사용자 경험을 향상시키는 방향으로 작업해주세요.',
                    'status_id' => 5, // 재요청
                    'request_date' => now()->subDays(4)->toDateString(),
                    'expected_date' => now()->addDays(10)->toDateString(),
                ],
                [
                    'title' => '쿠팡 상품 상세페이지 이미지 갤러리 기능 추가',
                    'content' => '쿠팡 상품 상세페이지에 이미지 갤러리 기능을 추가해주세요. 상품 이미지를 여러 장 보여줄 수 있는 슬라이더가 필요합니다.',
                    'status_id' => 1, // 접수
                    'request_date' => now()->subDays(6)->toDateString(),
                    'expected_date' => now()->addDays(2)->toDateString(),
                ],
                [
                    'title' => '배달의민족 주문 관리 시스템 백업 및 복구',
                    'content' => '배달의민족 주문 관리 시스템의 데이터 백업 및 복구 시스템을 구축해주세요. 정기적인 백업과 장애 시 복구가 가능하도록 해주세요.',
                    'status_id' => 1, // 접수
                    'request_date' => now()->subDays(7)->toDateString(),
                    'expected_date' => now()->addDays(14)->toDateString(),
                ],
                [
                    'title' => '토스 금융앱 알림 시스템 개선',
                    'content' => '토스 금융앱의 알림 시스템을 개선해주세요. 푸시 알림 설정과 개인화된 알림 기능이 필요합니다.',
                    'status_id' => 4, // 진행중
                    'request_date' => now()->subDays(2)->toDateString(),
                    'expected_date' => now()->addDays(3)->toDateString(),
                ],
                [
                    'title' => '스타벅스 모바일 주문 시스템 서버 최적화',
                    'content' => '스타벅스 모바일 주문 시스템의 서버 성능을 최적화해주세요. 주문량이 많을 때 발생하는 지연 현상을 개선해주세요.',
                    'status_id' => 1, // 접수
                    'request_date' => now()->subDays(1)->toDateString(),
                    'expected_date' => now()->addDays(2)->toDateString(),
                ],
                [
                    'title' => '넥슨 게임사 공식 홈페이지 메인 배너 교체',
                    'content' => '넥슨 게임사 공식 홈페이지의 메인 배너를 새로운 게임 출시에 맞춰 교체해주세요. 최신 게임 정보와 이벤트를 반영해주세요.',
                    'status_id' => 2, // 공수확인요청
                    'request_date' => now()->subDays(3)->toDateString(),
                    'expected_date' => now()->addDays(8)->toDateString(),
                ],
                [
                    'title' => '삼성전자 제품 지원 페이지 검색 기능 개선',
                    'content' => '삼성전자 제품 지원 페이지의 검색 기능을 개선해주세요. 제품명과 모델명으로 더 정확한 검색이 가능하도록 해주세요.',
                    'status_id' => 1, // 접수
                    'request_date' => now()->subDays(5)->toDateString(),
                    'expected_date' => now()->addDays(4)->toDateString(),
                ],
                [
                    'title' => 'LG전자 고객센터 채팅 상담 시스템 구축',
                    'content' => 'LG전자 고객센터에 실시간 채팅 상담 시스템을 구축해주세요. 고객이 대기 없이 상담받을 수 있는 기능이 필요합니다.',
                    'status_id' => 3, // 공수확인완료
                    'request_date' => now()->subDays(4)->toDateString(),
                    'expected_date' => now()->addDays(6)->toDateString(),
                ]
            ];
            
            foreach ($requests as $requestData) {
                $request = MaintenanceRequest::create([
                    'user_id' => $user->idx,
                    'manager_id' => null, // 외래키 제약조건 해결을 위해 null로 설정
                    'worker_id' => null, // 외래키 제약조건 해결을 위해 null로 설정
                    'type_id' => $type->idx,
                    'status_id' => $requestData['status_id'],
                    'title' => $requestData['title'],
                    'content' => $requestData['content'],
                    'request_date' => $requestData['request_date'],
                    'expected_date' => $requestData['expected_date'],
                    'expected_pm_hours' => rand(0, 10),
                    'expected_design_hours' => rand(0, 15),
                    'expected_pub_hours' => rand(0, 20),
                    'expected_dev_hours' => rand(0, 25),
                    'actual_pm_hours' => rand(0, 8),
                    'actual_design_hours' => rand(0, 12),
                    'actual_pub_hours' => rand(0, 18),
                    'actual_dev_hours' => rand(0, 22),
                ]);
                
                $this->command->info("유지보수 요청이 생성되었습니다. ID: {$request->idx} - {$requestData['title']}");
            }
            
            $this->command->info("총 " . count($requests) . "개의 유지보수 요청이 생성되었습니다.");
        } catch (\Exception $e) {
            $this->command->error("오류가 발생했습니다: " . $e->getMessage());
            $this->command->error("스택 트레이스: " . $e->getTraceAsString());
        }
    }
}
