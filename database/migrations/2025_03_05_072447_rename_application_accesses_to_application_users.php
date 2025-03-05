<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::rename('application_accesses', 'application_users');
    }

    public function down(): void
    {
        Schema::rename('application_users', 'application_accesses');
    }
};
