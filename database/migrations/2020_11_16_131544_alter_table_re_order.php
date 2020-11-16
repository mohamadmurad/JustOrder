<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableReOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('re_orders', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('re_orders', function (Blueprint $table) {
            //
        });
    }
}
