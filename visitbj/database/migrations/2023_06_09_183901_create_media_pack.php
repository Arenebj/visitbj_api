<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_park', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('path');
            $table->bigInteger('pack_id')->unsigned();
            $table->foreign('pack_id')->references('id')->on('pack');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_pack');
    }
};
