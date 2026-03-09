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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['Dog', 'Cat', 'Chicken','Pigeon' ,'Horse', 'Cow',]);
            $table->enum('age', [
                '1 W → 4 W',
                '1 M → 3 M',
                '3 M → 6 M',
                '6 M → 1 Y',
                '1 Y → 2 Y'
             ]);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
