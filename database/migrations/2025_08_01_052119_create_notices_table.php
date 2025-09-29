<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 공지사항 테이블 생성
     */
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id('idx');
            $table->unsignedBigInteger('user_id'); // 작성자 ID
            $table->string('title'); // 제목
            $table->text('content'); // 내용
            $table->boolean('is_important')->default(false); // 중요 표시
            $table->boolean('is_published')->default(true); // 발행 여부
            $table->timestamp('published_at')->nullable(); // 발행일
            $table->integer('view_count')->default(0); // 조회수
            $table->timestamps();

            // 외래키 제약
            $table->foreign('user_id')->references('idx')->on('users')->onDelete('cascade');

            // 인덱스
            $table->index(['user_id']);
            $table->index(['is_published']);
            $table->index(['is_important']);
            $table->index(['created_at']);
        });
    }

    /**
     * 테이블 삭제
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
