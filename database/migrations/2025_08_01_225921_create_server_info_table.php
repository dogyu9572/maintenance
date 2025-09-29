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
        Schema::create('server_info', function (Blueprint $table) {
            $table->id('idx');

            $table->string('domain')->nullable(); // 도메인
            $table->string('sub_domain')->nullable(); // 서브 도메인
            $table->string('admin_url')->nullable(); // 관리자 주소
            $table->string('admin_account')->nullable(); // 관리자 계정 (ID/PW)
            $table->string('development_language')->nullable(); // 개발언어(버전)
            $table->string('database_type')->nullable(); // DB 종류
            $table->string('domain_provider')->nullable(); // 도메인 기관
            $table->string('server_provider')->nullable(); // 서버 기관
            $table->string('ssl_provider')->nullable(); // SSL 기관
            $table->date('ssl_expiry_date')->nullable(); // SSL 만료일
            $table->string('ftp_host')->nullable(); // FTP 주소
            $table->string('ftp_id')->nullable(); // FTP ID
            $table->string('ftp_password')->nullable(); // FTP PW
            $table->string('db_host')->nullable(); // DB 호스트
            $table->string('db_id')->nullable(); // DB ID
            $table->string('db_password')->nullable(); // DB PW
            $table->text('notes')->nullable(); // 비고
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_info');
    }
};
