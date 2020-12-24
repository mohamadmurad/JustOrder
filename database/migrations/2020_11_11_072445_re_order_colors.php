<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReOrderColors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reOrders_colors', function (Blueprint $table) {
            $table->foreignId('reOrder_id');
            $table->foreign('reOrder_id')
                ->on('re_orders')
                ->references('id')->onDelete('CASCADE');


            $table->foreignId('color_id');
            $table->foreign('color_id')
                ->on('colors')
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
        Schema::dropIfExists('reOrders_colors');
    }
}
