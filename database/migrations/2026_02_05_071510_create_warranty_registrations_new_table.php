<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('warranty_registrations_new', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Dealer information
            $table->string('dealer_name');
            $table->string('dealer_state');
            $table->string('dealer_city');

            // Invoice information
            $table->string('invoice_number');
            $table->string('invoice_file_path');

            // Status
            $table->enum('status', ['pending', 'approved', 'rejected', 'modify'])->default('pending');
            $table->text('admin_remarks')->nullable();

            // Builder/Contractor flag
            $table->boolean('is_self_purchased')->default(true);

            $table->timestamps();

            // Index for faster queries
            $table->index('invoice_number');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('warranty_registrations_new');
    }
};
