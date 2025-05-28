<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->char('user_id', 26)->nullable()->change();
        });

        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->char('user_id', 26)->change();
        });

        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->char('user_id', 26)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
        });

        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
        });

        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
        });
    }
};
