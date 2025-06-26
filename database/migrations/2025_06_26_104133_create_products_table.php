<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('products')->insert([
            ['name' => 'Mikasa Floors'],
            ['name' => 'Mikasa Doors'],
            ['name' => 'Mikasa Ply'],
            ['name' => 'Greenlam Clads'],
            ['name' => 'NewMikaFx'],
            ['name' => 'Greenlam Sturdo'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
