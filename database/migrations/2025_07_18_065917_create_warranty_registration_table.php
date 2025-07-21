<?php

// database/migrations/2025_07_18_000000_create_warranty_registrations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('warranty_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('dealer_name');
            $table->string('dealer_city');
            // $table->string('place_of_purchase');
            $table->string('invoice_number');
            $table->string('upload_invoice'); // store filename
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warranty_registrations');
    }
};
