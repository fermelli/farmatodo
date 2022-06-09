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
        Schema::create('product_purchase', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('purchase_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->primary(['product_id', 'purchase_id']);
            $table->foreign('product_id')->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('no action');
            $table->foreign('purchase_id')->references('id')
                ->on('purchases')
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
        Schema::dropIfExists('product_purchase');
    }
};
