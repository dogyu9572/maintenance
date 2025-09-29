<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 유지보수 요청 테이블 생성
     */
    public function up(): void
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id('idx');
            $table->unsignedBigInteger('user_id'); // 요청자 ID
            $table->unsignedBigInteger('manager_id')->nullable(); // 담당 매니저 ID
            $table->unsignedBigInteger('worker_id')->nullable(); // 작업자 ID
            $table->unsignedBigInteger('type_id'); // 유지보수 유형 ID
            $table->unsignedBigInteger('status_id'); // 상태 ID
            $table->string('title'); // 제목
            $table->text('content'); // 내용
            $table->date('request_date'); // 요청일
            $table->date('expected_date')->nullable(); // 예상 완료일
            $table->date('completed_date')->nullable(); // 완료일
            
            // 예상 작업 시간
            $table->integer('expected_pm_hours')->default(0); // PM 시간
            $table->integer('expected_design_hours')->default(0); // 디자인 시간
            $table->integer('expected_pub_hours')->default(0); // 퍼블리싱 시간
            $table->integer('expected_dev_hours')->default(0); // 개발 시간
            
            // 실제 작업 시간
            $table->integer('actual_pm_hours')->default(0); // 실제 PM 시간
            $table->integer('actual_design_hours')->default(0); // 실제 디자인 시간
            $table->integer('actual_pub_hours')->default(0); // 실제 퍼블리싱 시간
            $table->integer('actual_dev_hours')->default(0); // 실제 개발 시간
            
            $table->boolean('is_urgent')->default(false); // 긴급 여부
            $table->text('issues')->nullable(); // 이슈 사항
            $table->string('report_title')->nullable(); // 보고서 제목
            $table->integer('progress_rate')->default(0); // 진행률
            $table->string('progress_status')->nullable(); // 진행 상태
            $table->text('notes')->nullable(); // 메모
            $table->timestamps();

            // 외래키 제약조건
            $table->foreign('user_id')->references('idx')->on('users')->onDelete('cascade');
            $table->foreign('manager_id')->references('idx')->on('managers')->onDelete('set null');
            $table->foreign('worker_id')->references('idx')->on('users')->onDelete('set null');
            $table->foreign('type_id')->references('idx')->on('maintenance_types')->onDelete('cascade');
            $table->foreign('status_id')->references('idx')->on('request_statuses')->onDelete('cascade');

            // 인덱스
            $table->index(['user_id']);
            $table->index(['manager_id']);
            $table->index(['worker_id']);
            $table->index(['type_id']);
            $table->index(['status_id']);
            $table->index(['request_date']);
            $table->index(['is_urgent']);
        });
    }

    /**
     * 테이블 삭제
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
