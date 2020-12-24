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
            $table->string('modelName')->nullable();
            $table->text('modelDesc')->nullable();

            $table->unsignedInteger('siresSizeQty')->nullable();
            $table->unsignedInteger('siresColorQty')->nullable();
            $table->unsignedInteger('siresQty')->nullable(); // عدد السيريات
            $table->unsignedInteger('quantity')->nullable(); // الكمية الكلية
            $table->unsignedInteger('reservedQuantity')->nullable(); // for delete
            $table->unsignedInteger('receivedQty')->default(0); // المستلمة
            $table->unsignedInteger('siresItemNumber')->default(0); // عدد القطع في السيري

           // $table->text('fabricType');
            $table->text('fabricFormula')->nullable();
           // $table->text('fabricCode');

//            $table->unsignedInteger('siresNumber');
//            $table->unsignedInteger('itemsNumber');

            $table->dateTime('orderDate');
            $table->dateTime('reservedDate')->nullable();
            $table->dateTime('fabricDate')->nullable();



            $table->boolean('done')->default(0);

            $table->text('notes')->nullable();

            $table->string('image')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();





            $table->foreignId('brand_id');
            $table->foreign('brand_id')
                ->on('brands')->references('id')->onDelete('CASCADE');;

            $table->foreignId('fabric_id');
            $table->foreign('fabric_id')
                ->on('fabrics')->references('id')->onDelete('CASCADE');;

            $table->foreignId('type_id');
            $table->foreign('type_id')
                ->on('types')->references('id')->onDelete('CASCADE');;

            $table->foreignId('group_id');
            $table->foreign('group_id')
                ->on('groups')->references('id')->onDelete('CASCADE');;

            $table->foreignId('subgroup_id');
            $table->foreign('subgroup_id')
                ->on('subgroups')->references('id')->onDelete('CASCADE');;

            $table->foreignId('season_id');
            $table->foreign('season_id')
                ->on('seasons')->references('id')->onDelete('CASCADE');;

            $table->foreignId('year_id');
            $table->foreign('year_id')
                ->on('years')->references('id')->onDelete('CASCADE');;

            $table->foreignId('supplier_id');
            $table->foreign('supplier_id')
                ->on('suppliers')->references('id')->onDelete('CASCADE');;


            $table->foreignId('fabric_source_id');
            $table->foreign('fabric_source_id')
                ->on('fabric_sources')->references('id')->onDelete('CASCADE');;


            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->on('users')->references('id');


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
