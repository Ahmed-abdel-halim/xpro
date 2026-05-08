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
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'teacher_id')) {
                $table->foreignId('teacher_id')->nullable()->after('student_id')->constrained('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('payments', 'sender_number')) {
                $table->string('sender_number')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('payments', 'proof_image')) {
                $table->string('proof_image')->nullable()->after('sender_number');
            }
            if (!Schema::hasColumn('payments', 'notes')) {
                $table->text('notes')->nullable()->after('proof_image');
            }
            if (!Schema::hasColumn('payments', 'payment_date')) {
                $table->timestamp('payment_date')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('payments', 'confirmed_at')) {
                $table->timestamp('confirmed_at')->nullable()->after('payment_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['teacher_id', 'sender_number', 'proof_image', 'notes', 'payment_date', 'confirmed_at']);
        });
    }
};
