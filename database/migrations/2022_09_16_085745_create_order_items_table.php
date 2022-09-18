<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            // $table->unsignedBigInteger('order_id')->index();
            // $table->unsignedBigInteger('product_id')->index();
            $table->bigInteger('order_id')->unsigned()->index();
            $table->bigInteger('product_id')->unsigned()->index();

            $table->unsignedInteger('quantity');
            $table->decimal('price', 20, 6);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

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
        Schema::dropIfExists('order_items');
    }
};
