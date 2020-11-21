<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id');
            $table->integer('category_id')->nullable();
            $table->longText('title');
            $table->longText('seo_title')->nullable();
            $table->longText('body');
            $table->string('image')->nullable();
            $table->longText('slug');
            $table->longText('meta_description');
            $table->longText('meta_keywords');
            $table->enum('status', ['PUBLISHED', 'DRAFT', 'PENDING'])->default('DRAFT');
            $table->tinyInteger('privacy')->default(0);
            $table->tinyInteger('is_own')->default(0);
            $table->bigInteger('views')->default(0);
            $table->timestamp('event_date')->default(null)->nullable();
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
        Schema::dropIfExists('posts');
    }
}
