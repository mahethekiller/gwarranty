<?php

// database/migrations/2025_07_18_000001_create_warranty_products_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('warranty_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warranty_registration_id')->constrained('warranty_registrations')->onDelete('cascade');
            $table->unsignedBigInteger('product_type'); // FK to products table if needed
            $table->integer('qty_purchased');
            $table->string('application_type')->nullable();
            $table->string('handover_certificate')->nullable(); // store file name
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warranty_products');
    }
};
