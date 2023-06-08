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
        Schema::create('parks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cover');
            $table->string('description');
            $table->integer('limit_person')->nullable();
            $table->string('duration');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('price');
            $table->string("exclusion")->nullable();
            $table->enum('type', ['fixed', 'standard', 'personalized']);
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
        Schema::dropIfExists('table_parks');
    }
};
