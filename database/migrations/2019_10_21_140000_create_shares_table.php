<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharesTable extends Migration
{
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token')->index();
            $table->bigInteger('post_id')->unsigned()->index();
            $table->dateTime('expires_at');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('shares', function (Blueprint $table) {
            $table->dropIndex(['post_id']);
        });

        Schema::dropIfExists('shares');
    }
}
