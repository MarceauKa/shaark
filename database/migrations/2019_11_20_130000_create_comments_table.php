<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('comment_id')->nullable()->index();
            $table->bigInteger('post_id')->unsigned()->index();
            $table->text('content');
            $table->bigInteger('user_id')->unsigned()->nullable()->index();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable()->index();
            $table->boolean('is_visible')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
