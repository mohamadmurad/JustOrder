<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreign('order_id')
                ->on('orders')
                ->references('id')->onDelete('CASCADE');

            $table->unsignedInteger('re_order_number')->default(1);

            $table->unsignedInteger('siresSizeQty')->nullable();
            $table->unsignedInteger('siresColorQty')->nullable();
            $table->unsignedInteger('siresQty')->nullable(); // عدد السيريات
            $table->unsignedInteger('quantity')->nullable(); // الكمية الكلية


            $table->unsignedInteger('receivedQty')->default(0); // المستلمة
            $table->unsignedInteger('siresItemNumber')->default(0); // عدد القطع في السيري


            $table->dateTime('orderDate');
            $table->dateTime('receivedDate')->nullable();
            $table->dateTime('fabricDate')->nullable();


            $table->boolean('done')->default(0);

            $table->text('notes')->nullable();

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
        Schema::dropIfExists('re_orders');
    }
}
