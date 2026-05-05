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
        Schema::table('students', function (Blueprint $table) {
            $table->index('status');
            $table->index('email');
        });

        $driver = Schema::getConnection()->getDriverName();
        if (in_array($driver, ['mysql', 'pgsql'], true)) {
            Schema::table('students', function (Blueprint $table) {
                $table->fullText(['name', 'address', 'email']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if (in_array($driver, ['mysql', 'pgsql'], true)) {
            Schema::table('students', function (Blueprint $table) {
                $table->dropFullText(['name', 'address', 'email']);
            });
        }

        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['email']);
        });
    }
};
