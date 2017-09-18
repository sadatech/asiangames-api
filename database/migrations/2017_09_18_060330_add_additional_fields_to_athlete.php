<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalFieldsToAthlete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('athletes', function (Blueprint $table) {
            //            
            $table->integer('typesport_id')->unsigned()->after('country_id');
            $table->foreign('typesport_id')->references('id')->on('type_sports');

            $table->float('weight', 8, 2)->nullable()->after('lastname');
            $table->float('height', 8, 2)->nullable()->after('lastname');
            $table->enum('gender_type', ['MALE', 'FEMALE'])->after('lastname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('athletes', function (Blueprint $table) {
            //
        });
    }
}
