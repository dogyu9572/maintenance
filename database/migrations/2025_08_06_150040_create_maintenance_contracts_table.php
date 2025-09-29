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
        Schema::create('maintenance_contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('사용자 ID');
            $table->date('contract_start')->comment('계약 시작일');
            $table->date('contract_end')->comment('계약 종료일');
            $table->integer('pm_hours')->default(0)->comment('PM,기획 공수');
            $table->integer('design_hours')->default(0)->comment('디자인 공수');
            $table->integer('publish_hours')->default(0)->comment('퍼블리싱 공수');
            $table->integer('dev_hours')->default(0)->comment('개발 공수');
            $table->string('contract_unit')->nullable()->comment('계약 공수 단위');
            $table->string('contract_file')->nullable()->comment('계약서 파일');
            $table->timestamps();

            $table->foreign('user_id')->references('idx')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_contracts');
    }
};
