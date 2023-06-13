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
    {//reference, mode_paiement et reservation(bollean)
        if(!Schema::hasColumn('user_pack','reference'))
        Schema::table('user_pack', function (Blueprint $table) {
            $table->string('reference')->nullable();
        });
        if(!Schema::hasColumn('user_pack','status'))
        Schema::table('user_pack', function (Blueprint $table) {
            $table->boolean('is_reserved')->nullable();
        });
        if(!Schema::hasColumn('user_pack','mode_paiement'))
        Schema::table('user_pack', function (Blueprint $table) {
            $table->boolean('mode_paiement')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_pack', function (Blueprint $table) {
            //
        });
    }
};
