<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistanceMosqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distance_mosque', function (Blueprint $table) {
            $table->increments('id');
            $table->float('distance', 2,1);

            $table->integer('distance_id')->unsigned();
            $table->foreign('distance_id')->references('id')->on('distances')->onDelete('cascade');

            $table->integer('mosque_id')->unsigned();
            $table->foreign('mosque_id')->references('id')->on('mosques')->onDelete('cascade');

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
        Schema::dropIfExists('distance_mosque');
    }
}
