<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrdersSizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_sizes', function (Blueprint $table) {
            $table->foreignId('order_id');
            $table->foreign('order_id')
                ->on('orders')
                ->references('id')->onDelete('CASCADE');

            $table->foreignId('size_id');
            $table->foreign('size_id')
                ->on('sizes')
                ->references('id')->onDelete('CASCADE');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders_sizes', function (Blueprint $table) {
            //
        });
    }
}
