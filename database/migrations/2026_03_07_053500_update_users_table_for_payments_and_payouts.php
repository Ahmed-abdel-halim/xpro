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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('commission_percentage', 5, 2)->default(20.00)->after('role');
            $table->boolean('is_free_trial_enabled')->default(true)->after('commission_percentage');
            $table->string('payout_method')->nullable()->after('avatar'); // 'vodafone_cash', 'instapay'
            $table->string('payout_details')->nullable()->after('payout_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['commission_percentage', 'is_free_trial_enabled', 'payout_method', 'payout_details']);
        });
    }
};
