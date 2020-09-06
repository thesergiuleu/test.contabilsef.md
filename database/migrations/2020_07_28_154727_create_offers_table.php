<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('vacancy');
            $table->string('location');
            $table->string('salary')->nullable();
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('studies')->nullable();
            $table->string('time_shift')->nullable();
            $table->string('logo')->nullable();
            $table->longText('description');
            $table->longText('requirements');
            $table->string('website')->nullable();
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
        Schema::dropIfExists('offers');
    }
}
