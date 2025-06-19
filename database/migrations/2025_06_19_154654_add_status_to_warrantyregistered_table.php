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
        Schema::table('warrantyregistered', function (Blueprint $table) {
            $table->enum('status', ['pending', 'modify', 'approved'])->default('pending')->after('user_id');
            $table->integer('checked_by')->nullable()->after('status');
            $table->integer('modified_by')->nullable()->after('checked_by');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warrantyregistered', function (Blueprint $table) {
            $table->dropColumn(['status', 'checked_by', 'modified_by']);
        });
    }
};
