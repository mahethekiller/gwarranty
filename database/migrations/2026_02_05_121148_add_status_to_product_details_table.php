<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected', 'modify'])
                  ->default('pending')
                  ->after('product_thickness');
            $table->text('admin_remarks')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropColumn(['status', 'admin_remarks']);
        });
    }
};
