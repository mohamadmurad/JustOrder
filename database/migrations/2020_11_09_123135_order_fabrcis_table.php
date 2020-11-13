<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderFabrcisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_fabrics', function (Blueprint $table) {
            $table->foreignId('order_id');

            $table->foreign('order_id')
                ->on('orders')
                ->references('id');


            $table->foreignId('fabric_id');

            $table->foreign('fabric_id')
                ->on('fabrics')
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
        Schema::dropIfExists('orders_fabrics');
    }
}
