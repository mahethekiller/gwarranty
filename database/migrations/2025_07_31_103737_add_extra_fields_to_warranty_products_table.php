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
        Schema::table('warranty_products', function (Blueprint $table) {
            //
            $table->string('branch_name')->nullable()->after('product_name');
            $table->enum('branch_admin_status', ['pending', 'modify', 'approved'])->default('pending')->nullable()->after('product_status');
            $table->enum('country_admin_status', ['pending', 'modify', 'approved'])->default('pending')->nullable()->after('product_status');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warranty_products', function (Blueprint $table) {
            //
            $table->dropColumn('branch_name');
            $table->dropColumn('branch_admin_status');
            $table->dropColumn('country_admin_status');
        });
    }
};
