<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKindSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kind_sports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branchsport_id')->unsigned();
            $table->foreign('branchsport_id')->references('id')->on('branch_sports');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kind_sports');
    }
}
