<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('postable_id')->nullable()->unsigned()->index();
            $table->string('postable_type')->nullable()->index();
            $table->boolean('is_private')->default(false)->index();
            $table->timestamps();
            $table->index(['postable_id', 'postable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
