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
            $table->text('country_admin_remarks')->nullable()->after('country_admin_status');
            $table->text('branch_admin_remarks')->nullable()->after('country_admin_status');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warranty_products', function (Blueprint $table) {
            //
            $table->dropColumn('country_admin_remarks');
            $table->dropColumn('branch_admin_remarks');
        });
    }
};
