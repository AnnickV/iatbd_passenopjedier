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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->integer('age');
            $table->string('breed')->nullable();
            $table->text('description')->nullable();
            $table->decimal('hourly_rate', 8, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('image');
            $table->string('status')->default('available');
            $table->timestamps();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
