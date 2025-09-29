<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id('idx');

            $table->date('contract_start'); // 계약 시작일
            $table->date('contract_end'); // 계약 종료일
            $table->decimal('pm_hours', 8, 2)->default(0); // PM/기획 공수
            $table->decimal('design_hours', 8, 2)->default(0); // 디자인 공수
            $table->decimal('publishing_hours', 8, 2)->default(0); // 퍼블리싱 공수
            $table->decimal('development_hours', 8, 2)->default(0); // 개발 공수
            $table->string('contract_file_path')->nullable(); // 계약서 파일 경로
            $table->string('contract_file_name')->nullable(); // 계약서 파일명
            $table->integer('contract_order')->default(1); // 계약 순서
            $table->boolean('is_active')->default(true); // 활성화 여부
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
