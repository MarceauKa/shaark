<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHealthChecksToLinksTable extends Migration
{
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->boolean('is_watched')->after('url')->default(true);
            $table->unsignedSmallInteger('http_status')->after('is_watched')->nullable();
            $table->timestamp('http_checked_at')->after('http_status')->nullable();

            $table->index('http_status');
        });
    }

    public function down()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn([
                'is_watched',
                'http_status',
                'http_checked_at',
            ]);
        });
    }
}
