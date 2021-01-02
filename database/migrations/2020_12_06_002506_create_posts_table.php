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
            $table->string('acc_user_id');
            $table->string('name');
            $table->longText('profile_image');
            $table->longText('post_image')->nullable();
            $table->longText('post_desc')->nullable();
            $table->longText('user_likes')->nullable();
            $table->longText('post_tags')->nullable();
            $table->bigInteger('likes')->nullable();
            $table->longText('post_comments')->nullable();
            $table->string('comment_count');
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
