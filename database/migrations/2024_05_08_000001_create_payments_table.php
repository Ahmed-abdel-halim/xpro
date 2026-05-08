<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained()->onDelete('cascade');
                $table->foreignId('teacher_id')->nullable()->constrained()->onDelete('cascade');
                $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
                $table->decimal('amount', 10, 2);
                $table->string('payment_method'); // 'cash', 'bank_transfer', 'wallet'
                $table->string('transaction_id')->nullable();
                $table->string('bank_name')->nullable();
                $table->string('account_number')->nullable();
                $table->text('notes')->nullable();
                $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
                $table->timestamp('payment_date')->nullable();
                $table->timestamp('confirmed_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
