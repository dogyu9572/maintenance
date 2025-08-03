<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('idx')->comment('사용자 번호');
            $table->string('name')->comment('사용자명');
            $table->string('login_id')->unique()->comment('로그인 ID');
            $table->string('email')->unique()->comment('이메일');
            $table->string('password')->comment('비밀번호');
            $table->string('phone')->nullable()->comment('연락처');
            $table->string('position')->nullable()->comment('직책');
            $table->boolean('is_admin')->default(false)->comment('관리자 여부');
            $table->enum('account_type', ['new', 'renewal'])->default('new')->comment('계정유형');
            $table->boolean('is_manpower_check')->default(false)->comment('공수확인');
            $table->enum('client_type', ['association', 'company', 'individual'])->nullable()->comment('고객유형');
            $table->boolean('monthly_report_enabled')->default(true)->comment('월간보고서');
            $table->foreignId('client_id')->nullable()->constrained('clients', 'idx')->onDelete('set null')->comment('클라이언트 ID');
            $table->date('contract_start')->nullable()->comment('계약시작일');
            $table->date('contract_end')->nullable()->comment('계약종료일');
            $table->boolean('is_active')->default(true)->comment('활성화');
            $table->rememberToken()->comment('로그인토큰');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
