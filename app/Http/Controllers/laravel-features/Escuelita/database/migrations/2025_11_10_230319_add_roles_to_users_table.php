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
        Schema::table('users', function (Blueprint $table) {
            // Almacenará 'admin', 'profesor', o 'alumno'
            $table->string('role')->default('alumno')->after('password'); 

            // Almacenará la matricula (ej. 'p24000001' o '21220501')
            // Es 'nullable' para que los admins (que no tienen matrícula) puedan existir.
            $table->string('matricula')->nullable()->unique()->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('matricula');
        });
    }
};