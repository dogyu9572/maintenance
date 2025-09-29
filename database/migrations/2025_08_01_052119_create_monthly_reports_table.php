<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 월간 보고서 테이블 생성
     */
    public function up(): void
    {
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->id('idx');
            $table->unsignedBigInteger('user_id'); // 사용자 ID
            $table->unsignedBigInteger('client_id')->nullable(); // 고객사 ID
            $table->integer('year'); // 년도
            $table->integer('month'); // 월
            $table->date('work_start_date')->nullable(); // 작업 시작일
            $table->date('work_end_date')->nullable(); // 작업 종료일
            $table->string('project_name')->nullable(); // 프로젝트명
            $table->string('manager_name')->nullable(); // 담당자명
            $table->string('company_name')->nullable(); // 회사명
            $table->string('title'); // 제목
            $table->text('content'); // 내용
            $table->enum('status', ['draft', 'published'])->default('draft'); // 상태
            $table->boolean('is_published')->default(true); // 발행 여부
            $table->timestamps();

            // 외래키 제약조건
            $table->foreign('user_id')->references('idx')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('idx')->on('users')->onDelete('set null');

            // 인덱스
            $table->index(['user_id', 'year', 'month']);
            $table->index(['client_id']);
            $table->index(['status']);
        });
    }

    /**
     * 테이블 삭제
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_reports');
    }
};
