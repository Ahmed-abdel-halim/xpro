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
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('course_id')->constrained()->onDelete('cascade');
                $table->decimal('amount', 8, 2);
                $table->string('payment_method'); // Vodafone Cash, InstaPay, etc.
                $table->string('transaction_id')->nullable();
                $table->string('status')->default('pending'); // pending, completed, failed
                $table->decimal('commission_amount', 8, 2)->default(0);
                $table->decimal('teacher_amount', 8, 2)->default(0);
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
