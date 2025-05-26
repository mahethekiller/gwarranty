<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warrantyregistered', function (Blueprint $table) {
            $table->id();

            $table->string('product_type');
            $table->integer('qty_purchased');
            $table->enum('application', ["Mikasa Floors", "Mikasa Doors", "Mikasa Ply", "Greenlam Clads", "NewMikaFx", "Greenlam Sturdo"]);
            $table->string('place_of_purchase');
            $table->string('invoice_number');
            $table->string('upload_invoice');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warrantyregistered');
    }
};
