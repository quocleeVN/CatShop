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
        Schema::create('cats', function (Blueprint $table) {
            $table->id('cat_id');
            $table->foreignId('breed_id')->constrained('cat_breeds', 'breed_id')->restrictOnDelete();
            $table->string('name', 100);
            $table->decimal('price', 12, 2);
            $table->integer('age_in_months');
            $table->enum('gender', ['male', 'female']);
            $table->string('color', 50)->nullable();
            $table->decimal('weight', 4, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('health_status', 100)->nullable();
            $table->boolean('is_vaccinated')->default(false);
            $table->enum('stock_status', ['available', 'sold', 'reserved'])->default('available');
            $table->string('link_image', 500)->nullable();
            $table->timestamps(); // created_at, updated_at

            $table->index('breed_id');
            $table->index('price');
            $table->index('stock_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cats');
    }
};
