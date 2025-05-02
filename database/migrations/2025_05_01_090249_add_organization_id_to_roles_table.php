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
        Schema::table('roles', function (Blueprint $table) {
            $table->foreignUlid('organization_id')->nullable();

            $table->dropUnique(['name', 'application_id']);

            $table->unique(['name', 'application_id', 'organization_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');

            $table->dropUnique(['name', 'application_id', 'organization_id']);
            $table->unique(['name', 'application_id']);
        });
    }
};
