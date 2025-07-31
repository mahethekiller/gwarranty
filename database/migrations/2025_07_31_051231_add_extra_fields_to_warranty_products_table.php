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
            $table->date('date_of_issuance')->nullable()->after('product_type'); // Date
            $table->date('invoice_date')->nullable()->after('date_of_issuance'); // Date
            $table->string('execution_agency')->nullable()->after('invoice_date'); // Text
            $table->date('handover_certificate_date')->nullable()->after('execution_agency'); // Date
            $table->string('product_code')->nullable()->after('handover_certificate_date'); // Text
            $table->string('surface_treatment_type')->nullable()->after('product_code'); // Text
            $table->string('product_thickness')->nullable()->after('surface_treatment_type'); // Text
            $table->string('project_location')->nullable()->after('product_thickness'); // Text
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warranty_products', function (Blueprint $table) {
            $table->dropColumn([
                'date_of_issuance',
                'invoice_date',
                'execution_agency',
                'handover_certificate_date',
                'product_code',
                'surface_treatment_type',
                'product_thickness',
                'project_location',
            ]);
        });
    }
};
