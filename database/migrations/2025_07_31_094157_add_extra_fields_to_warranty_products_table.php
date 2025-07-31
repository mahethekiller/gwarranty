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
            $table->string('product_name')->nullable()->after('invoice_date'); // Text
            $table->string('warranty_years')->nullable()->after('product_name'); // Text
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warranty_products', function (Blueprint $table) {
            //
            $table->dropColumn([
                'product_name',
                'warranty_years',
            ]);
        });
    }
};
