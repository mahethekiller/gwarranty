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
            $table->json('products_jsonFloor')->nullable()->after('products_json');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warranty_products', function (Blueprint $table) {
            //
            $table->dropColumn('products_jsonFloor');
        });
    }
};
