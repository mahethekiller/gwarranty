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
        //
         Schema::table('warranty_products', function (Blueprint $table) {
            $table->bigInteger('total_quantity')->default(0);
            $table->enum('product_status', ['pending', 'modify', 'approved'])->default('pending');
            $table->text('remarks')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('warranty_products', function (Blueprint $table) {
            $table->dropColumn('total_quantity');
            $table->dropColumn('product_status');
            $table->dropColumn('remarks');
        });
    }
};
