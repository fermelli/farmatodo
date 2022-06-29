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
        Schema::table('product_purchase', function (Blueprint $table) {
            $table->decimal('price', 8, 3)->after('quantity');
            $table->unsignedBigInteger('discount_id')->after('price')->nullable()->default(null);

            $table->foreign('discount_id')->references('id')->on('discounts')
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
        Schema::table('product_purchase', function (Blueprint $table) {
            $table->dropColumn('price');
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['discount_id']);
            $table->dropColumn('discount_id');
            Schema::enableForeignKeyConstraints();
        });
    }
};
