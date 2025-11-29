<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('test_executions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_run_id')->constrained()->onDelete('cascade');
            $table->foreignId('test_case_id')->constrained()->onDelete('cascade');
            $table->foreignId('executed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['pending', 'passed', 'failed', 'blocked', 'skipped'])->default('pending');
            $table->text('actual_result')->nullable();
            $table->text('comments')->nullable();
            $table->integer('execution_time')->nullable(); // in minutes
            $table->timestamp('executed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_executions');
    }
};