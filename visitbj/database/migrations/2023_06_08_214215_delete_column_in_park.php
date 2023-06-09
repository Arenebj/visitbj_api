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
        if(Schema::hasColumn('parks','theme_id'))
        Schema::table('parks', function (Blueprint $table) {
            $table->dropForeign('parks_theme_id_foreign');
            $table->dropColumn('theme_id');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('park', function (Blueprint $table) {
            //
        });
    }
};
