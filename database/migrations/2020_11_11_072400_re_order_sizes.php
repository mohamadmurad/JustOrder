<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReOrderSizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reOrders_sizes', function (Blueprint $table) {
            $table->foreignId('reOrder_id');
            $table->foreign('reOrder_id')
                ->on('re_orders')
                ->references('id')->onDelete('CASCADE');

            $table->foreignId('size_id');
            $table->foreign('size_id')
                ->on('sizes')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reOrders_sizes');
    }
}
