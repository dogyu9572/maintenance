<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 사용자 테이블 생성
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('idx');
            $table->string('name'); // 이름
            $table->string('login_id')->unique(); // 로그인 ID
            $table->string('email')->unique()->nullable(); // 이메일
            $table->string('password'); // 비밀번호
            $table->string('phone')->nullable(); // 전화번호
            $table->string('position')->nullable(); // 직책
            
            // 권한 관련
            $table->boolean('is_admin')->default(false); // 관리자 여부
            $table->enum('account_type', ['new', 'renewal'])->default('new'); // 계정 유형
            $table->boolean('is_manpower_check')->default(false); // 공수 확인 여부
            
            // 고객사 정보
            $table->enum('client_type', ['association', 'company', 'individual'])->nullable(); // 고객사 유형
            $table->boolean('monthly_report_enabled')->default(true); // 월간 보고서 사용 여부
            $table->date('contract_start')->nullable(); // 계약 시작일
            $table->date('contract_end')->nullable(); // 계약 종료일
            $table->boolean('is_active')->default(true); // 활성화 여부
            $table->boolean('is_confirmed_client')->default(false); // 확인된 고객사 여부
            
            // 계정 정보
            $table->string('member_type')->nullable(); // 회원 유형
            $table->string('new_type')->nullable(); // 신규 유형
            $table->string('monthly_report')->nullable(); // 월간 보고서
            
            // 담당자 정보
            $table->string('manager_name')->nullable(); // 담당자명
            $table->string('manager_position')->nullable(); // 담당자 직책
            $table->string('manager_phone')->nullable(); // 담당자 전화번호
            $table->string('manager_email')->nullable(); // 담당자 이메일
            
            // 연락처 정보 1
            $table->string('contact1_name')->nullable(); // 연락처1 이름
            $table->string('contact1_position')->nullable(); // 연락처1 직책
            $table->string('contact1_phone')->nullable(); // 연락처1 전화번호
            $table->string('contact1_email')->nullable(); // 연락처1 이메일
            
            // 연락처 정보 2
            $table->string('contact2_name')->nullable(); // 연락처2 이름
            $table->string('contact2_position')->nullable(); // 연락처2 직책
            $table->string('contact2_phone')->nullable(); // 연락처2 전화번호
            $table->string('contact2_email')->nullable(); // 연락처2 이메일
            
            // 연락처 정보 3
            $table->string('contact3_name')->nullable(); // 연락처3 이름
            $table->string('contact3_position')->nullable(); // 연락처3 직책
            $table->string('contact3_phone')->nullable(); // 연락처3 전화번호
            $table->string('contact3_email')->nullable(); // 연락처3 이메일
            
            // 기술 정보
            $table->string('domain')->nullable(); // 도메인
            $table->string('sub_domain')->nullable(); // 서브도메인
            $table->string('admin_url')->nullable(); // 관리자 URL
            $table->string('admin_account')->nullable(); // 관리자 계정
            $table->string('dev_language')->nullable(); // 개발 언어
            $table->string('db_type')->nullable(); // 데이터베이스 유형
            
            // 대행사 정보
            $table->string('domain_agency')->nullable(); // 도메인 대행사
            $table->string('server_agency')->nullable(); // 서버 대행사
            $table->string('ssl_agency')->nullable(); // SSL 대행사
            $table->string('ssl_expiry')->nullable(); // SSL 만료일
            
            // FTP 정보
            $table->string('ftp_host')->nullable(); // FTP 호스트
            $table->string('ftp_id')->nullable(); // FTP ID
            $table->string('ftp_password')->nullable(); // FTP 비밀번호
            $table->string('ftp_id2')->nullable(); // FTP ID2
            
            // 데이터베이스 정보
            $table->string('db_host')->nullable(); // DB 호스트
            $table->string('db_id')->nullable(); // DB ID
            $table->string('db_host2')->nullable(); // DB 호스트2
            $table->string('db_id2')->nullable(); // DB ID2
            
            $table->text('notes')->nullable(); // 메모
            $table->string('remember_token', 100)->nullable(); // 리멤버 토큰
            $table->timestamps();

            // 인덱스
            $table->index(['is_admin']);
            $table->index(['client_type']);
            $table->index(['is_active']);
            $table->index(['monthly_report_enabled']);
            $table->index(['contract_start', 'contract_end']);
        });
    }

    /**
     * 테이블 삭제
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
