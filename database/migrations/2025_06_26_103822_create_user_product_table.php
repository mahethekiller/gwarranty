<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProductTable extends Migration
{
    public function up()
    {
        Schema::create('user_product', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('product_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_product');
    }
}
