<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->nullable()->after('name');
            $table->string('nip', 50)->nullable()->after('address');
            $table->string('nis', 50)->nullable()->after('nip');
            $table->string('kelas', 50)->nullable()->after('nis');

            $table->unique('username');
            $table->unique('nip');
            $table->unique('nis');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropUnique(['nip']);
            $table->dropUnique(['nis']);
            $table->dropColumn(['username', 'nip', 'nis', 'kelas']);
        });
    }
};
