<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('warranty_registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->enum('status', ['pending', 'modify', 'approved'])->default('pending')->after('upload_invoice');
            $table->unsignedBigInteger('modified_by')->nullable()->after('status');
            $table->unsignedBigInteger('checked_by')->nullable()->after('modified_by');
            $table->text('remarks')->nullable()->after('checked_by');

            // Optional: Add foreign keys if user IDs relate to the users table
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('checked_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('warranty_registrations', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'status', 'modified_by', 'checked_by', 'remarks']);
        });
    }
};
