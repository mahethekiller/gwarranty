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
        Schema::table('warranty_registrations', function (Blueprint $table) {
            //
            $table->string('dealer_state')->after('dealer_city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warranty_registrations', function (Blueprint $table) {
            //
            $table->dropColumn('dealer_state');
        });
    }
};
