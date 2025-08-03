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
        Schema::create('clients', function (Blueprint $table) {
            $table->id('idx');
            $table->string('name');
            $table->enum('client_type', ['association', 'company', 'individual'])->nullable(); // 타입 (협회/회사/개인)
            $table->boolean('is_manpower_check')->default(false); // 공수 확인 고객사
            $table->boolean('monthly_report_enabled')->default(true); // 월간보고서 사용
            $table->date('contract_start');
            $table->date('contract_end');
            $table->string('website_url')->nullable();
            $table->boolean('is_active')->default(true); // 활성화 여부
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
