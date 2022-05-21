<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('buy_url');
            $table->text('description');
            $table->unsignedDouble('price');
            $table->string('image');
            $table->unsignedInteger('discount')->nullable()->default(0);
            $table->unsignedInteger('ivmax_toothbrush_count')->default(0)->nullable();
            $table->unsignedInteger('brush_head_count')->default(0)->nullable();
            $table->unsignedInteger('toothpaste_cartridges_count')->default(0)->nullable();

            $table->timestamps();
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
    }
}
