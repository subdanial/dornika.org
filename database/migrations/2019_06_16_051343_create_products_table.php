<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->nullable();
            $table->string('title');
            $table->string('image')->nullable()->default('images/categories-default.jpg');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description');
            $table->string('slug')->unique();
            $table->string('image')->default('images/products-default.jpg');
            $table->bigInteger('price_1');
            $table->bigInteger('price_2');
            $table->bigInteger('price_3');
            $table->bigInteger('price_4');
            $table->bigInteger('category_id')->unsigned();
            $table->integer('number_in_box')->unsigned();
            $table->integer('available')->unsigned()->default(0);
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
}
