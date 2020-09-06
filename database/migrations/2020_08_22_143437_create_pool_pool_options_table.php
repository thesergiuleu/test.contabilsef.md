<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoolPoolOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pool_pool_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pool_id');
            $table->unsignedBigInteger('pool_option_id');
            $table->timestamps();

            $table->foreign('pool_id')
                ->references('id')->on('pools')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('pool_option_id')
                ->references('id')->on('pool_options')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pool_pool_options');
    }
}
