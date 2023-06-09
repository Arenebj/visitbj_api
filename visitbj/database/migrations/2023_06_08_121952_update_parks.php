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
        if (!Schema::hasColumn('parks', 'theme_id')){
            Schema::table('parks', function (Blueprint $table) {
                $table->bigInteger('theme_id')->unsigned();
                $table->foreign('theme_id')->references('id')->on('parks');
            });}
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
