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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->char('application_id', 26);
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['application_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
