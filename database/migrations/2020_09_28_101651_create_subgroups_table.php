<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubgroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subgroups', function (Blueprint $table) {
            $table->id('id');

            $table->string('name');

            $table->foreignId('group_id');

            $table->unsignedBigInteger('idNum');
            $table->foreign('group_id')
                ->on('groups')
                ->references('id');

            $table->unique(['id', 'group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subgroups');
    }
}
