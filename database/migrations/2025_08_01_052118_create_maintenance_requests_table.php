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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id('idx');
            $table->foreignId('user_id')->constrained('users', 'idx')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients', 'idx')->onDelete('cascade');
            $table->foreignId('manager_id')->nullable()->constrained('users', 'idx')->onDelete('set null');
            $table->foreignId('worker_id')->nullable()->constrained('users', 'idx')->onDelete('set null');
            $table->foreignId('type_id')->constrained('maintenance_types', 'idx')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('request_statuses', 'idx')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->date('request_date');
            $table->date('expected_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
