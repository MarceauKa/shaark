<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginsTable extends Migration
{
    public function up()
    {
        Schema::create('logins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->ipAddress('ip_address');
            $table->string('type')->default(\Lab404\AuthChecker\Models\Login::TYPE_LOGIN)->index();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('device_id')->unsigned()->index()->nullable();
            $table->timestamps();

            // $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('logins');
    }
}
