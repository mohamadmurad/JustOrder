<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();
            $table->string('barcode',50);
            $table->string('modelName');
            $table->text('modelDesc');

            $table->unsignedInteger('siresSizeQty');
            $table->unsignedInteger('siresColorQty');
            $table->unsignedInteger('siresQty');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('reservedQuantity');
            $table->unsignedInteger('receivedQty')->default(0);

           // $table->text('fabricType');
            $table->text('fabricFormula');
           // $table->text('fabricCode');

//            $table->unsignedInteger('siresNumber');
//            $table->unsignedInteger('itemsNumber');

            $table->dateTime('orderDate');
            $table->dateTime('reservedDate')->nullable();



            $table->boolean('done');

            $table->text('notes');

            $table->string('image')->nullable();





            $table->foreignId('brand_id');
            $table->foreign('brand_id')
                ->on('brands')->references('id');

            $table->foreignId('fabric_id');
            $table->foreign('fabric_id')
                ->on('fabrics')->references('id');

            $table->foreignId('type_id');
            $table->foreign('type_id')
                ->on('types')->references('id');

            $table->foreignId('group_id');
            $table->foreign('group_id')
                ->on('groups')->references('id');

            $table->foreignId('subgroup_id');
            $table->foreign('subgroup_id')
                ->on('subgroups')->references('id');

            $table->foreignId('season_id');
            $table->foreign('season_id')
                ->on('seasons')->references('id');

            $table->foreignId('year_id');
            $table->foreign('year_id')
                ->on('years')->references('id');

            $table->foreignId('supplier_id');
            $table->foreign('supplier_id')
                ->on('suppliers')->references('id');


            $table->foreignId('fabric_source_id');
            $table->foreign('fabric_source_id')
                ->on('fabric_sources')->references('id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
