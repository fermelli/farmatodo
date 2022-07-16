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
        Schema::create('discount_product', function (Blueprint $table) {
            $table->unsignedBigInteger('discount_id');
            $table->unsignedBigInteger('product_id');

            $table->primary(['discount_id', 'product_id']);

            $table->foreign('discount_id')->references('id')
                ->on('discounts')
                ->onUpdate('cascade')
                ->onDelete('no action');
            $table->foreign('product_id')->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_product');
    }
};
