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
        Schema::create('managers', function (Blueprint $table) {
            $table->id('idx');

            $table->string('name'); // 담당자 이름
            $table->string('position')->nullable(); // 직위/직급
            $table->string('phone')->nullable(); // 연락처
            $table->string('email')->nullable(); // 이메일
            $table->enum('role', ['primary', 'secondary'])->default('secondary'); // 대표 담당자 여부
            $table->integer('manager_order')->default(1); // 담당자 순서
            $table->boolean('is_active')->default(true); // 활성화 여부
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
    }
};
