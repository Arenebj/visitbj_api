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
        if(Schema::hasColumn('hotels','city_id'))
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropForeign('hotels_city_id_foreign');
            $table->dropColumn('city_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel', function (Blueprint $table) {
            //
        });
    }
};
