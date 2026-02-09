<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->json('fields')->nullable()->comment('Fields required for this product type');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert product types
        DB::table('product_types')->insert([
            ['name' => 'Mikasa Ply', 'slug' => 'mikasa-ply', 'sort_order' => 1],
            ['name' => 'Greenlam Clads', 'slug' => 'greenlam-clads', 'sort_order' => 2],
            ['name' => 'MikasaFx', 'slug' => 'mikasafx', 'sort_order' => 3],
            ['name' => 'Greenlam Sturdo', 'slug' => 'greenlam-sturdo', 'sort_order' => 4],
            ['name' => 'Mikasa Floors', 'slug' => 'mikasa-floors', 'sort_order' => 5],
            ['name' => 'Mikasa Doors', 'slug' => 'mikasa-doors', 'sort_order' => 6],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('product_types');
    }
};
