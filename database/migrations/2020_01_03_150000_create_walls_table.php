<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWallsTable extends Migration
{
    public function up()
    {
        Schema::create('walls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('restrict_tags')->nullable();
            $table->text('restrict_cards')->nullable();
            $table->text('appearance')->nullable();
            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->boolean('is_private')->default(false)->index();
            $table->boolean('is_default')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('walls');
    }
}
