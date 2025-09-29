<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notice_files', function (Blueprint $table) {
            $table->id('idx')->comment('첨부파일 번호');
            $table->foreignId('notice_id')->constrained('notices', 'idx')->onDelete('cascade')->comment('공지 ID');
            $table->string('original_name')->comment('원본 파일명');
            $table->string('file_path')->comment('저장 경로');
            $table->unsignedBigInteger('file_size')->default(0)->comment('파일 크기');
            $table->string('file_type')->nullable()->comment('MIME 타입');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notice_files');
    }
};


