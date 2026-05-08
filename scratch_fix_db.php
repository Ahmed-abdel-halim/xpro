<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Schema::table('payments', function (Blueprint $table) {
    if (!Schema::hasColumn('payments', 'is_commission_paid')) {
        $table->boolean('is_commission_paid')->default(false)->after('teacher_amount');
        echo "Column added successfully.\n";
    } else {
        echo "Column already exists.\n";
    }
});
