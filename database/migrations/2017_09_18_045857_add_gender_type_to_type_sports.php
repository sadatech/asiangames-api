<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenderTypeToTypeSports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_sports', function (Blueprint $table) {
            //
            $table->enum('gender_type', ['MALE', 'FEMALE', 'MIXED'])->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_sports', function (Blueprint $table) {
            //
        });
    }
}
