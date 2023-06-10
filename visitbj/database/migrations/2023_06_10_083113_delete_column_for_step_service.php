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
        if(Schema::hasColumn('step_service','pack_id'))
        Schema::table('step_service', function (Blueprint $table) {
            $table->dropForeign('step_service_pack_id_foreign');
            $table->dropColumn('pack_id');

        });
        if(!Schema::hasColumn('step_service','step_id'))
        Schema::table('step_service', function (Blueprint $table) {
            $table->bigInteger('step_id')->unsigned();
            $table->foreign('step_id')->references('id')->on('step');
        });
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
