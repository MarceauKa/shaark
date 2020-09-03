<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHealthChecksToLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->boolean('is_health_check_enabled')->after('url')->default(true);
            $table->unsignedSmallInteger('http_status')->after('is_health_check_enabled')->nullable();
            $table->timestamp('http_checked_at')->after('http_status')->nullable();

            $table->index('http_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn([
                'is_health_check_enabled',
                'http_status',
                'http_checked_at',
            ]);
        });
    }
}
