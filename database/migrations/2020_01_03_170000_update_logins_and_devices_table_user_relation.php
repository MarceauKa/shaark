<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLoginsAndDevicesTableUserRelation extends Migration
{
    public function up()
    {
        Schema::table('logins', function (Blueprint $table) {
            $table->string('user_type')->after('user_id')->nullable();
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->string('user_type')->after('user_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('logins', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });
    }
}
