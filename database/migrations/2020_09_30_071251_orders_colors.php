<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrdersColors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_colors', function (Blueprint $table) {
            $table->foreignId('order_id');
            $table->foreign('order_id')
                ->on('orders')
                ->references('id')->onDelete('CASCADE');

            $table->foreignId('color_id');
            $table->foreign('color_id')
                ->on('colors')
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
        Schema::table('orders_colors', function (Blueprint $table) {
            //
        });
    }
}
