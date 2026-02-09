<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warranty_registration_id')->constrained('warranty_registrations_new')->onDelete('cascade');
            $table->foreignId('product_type_id')->constrained();
            $table->foreignId('variant_id')->nullable()->constrained('product_type_variants');

            // Dynamic fields based on product type
            $table->string('variant')->nullable();
            $table->string('product_name_design')->nullable();
            $table->string('product_category')->nullable();
            $table->integer('no_of_boxes')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('area_sqft', 10, 2)->nullable();
            $table->string('handover_certificate')->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('uom')->nullable();
            $table->text('site_address')->nullable();
            $table->string('product_thickness')->nullable();

            $table->timestamps();

            // Indexes for better performance
            $table->index('warranty_registration_id');
            $table->index('product_type_id');
            $table->index('variant_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_details');
    }
};
