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
        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->date('birth_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->enum('age', [
            '1 W → 4 W',
            '1 M → 3 M',
            '3 M → 6 M',
            '6 M → 1 Y'
            ]);
            $table->dropColumn('birth_date');
        });
    }
};
