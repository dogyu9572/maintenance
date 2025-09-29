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
        Schema::create('comments', function (Blueprint $table) {
            $table->id('idx');
            $table->unsignedBigInteger('maintenance_request_id');
            $table->unsignedBigInteger('user_id');
            $table->text('content');
            $table->enum('type', ['comment', 'reply', 'rework', 'complete'])->default('comment');
            $table->timestamps();

            $table->foreign('maintenance_request_id')->references('idx')->on('maintenance_requests')->onDelete('cascade');
            $table->foreign('user_id')->references('idx')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
