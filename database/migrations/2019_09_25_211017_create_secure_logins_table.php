<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecureLoginsTable extends Migration
{
    public function up()
    {
        Schema::create('secure_logins', function (Blueprint $table) {
            $table->string('token')->unique()->index();
            $table->string('code')->unique()->index();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->dateTime('expires_at')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('secure_logins');
    }
}
