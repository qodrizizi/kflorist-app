<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bonsais', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('species')->nullable();
            $table->integer('age_years')->nullable();
            $table->integer('age_months')->nullable();
            $table->decimal('height_cm', 8, 2)->nullable();
            $table->decimal('trunk_diameter_cm', 8, 2)->nullable();
            $table->string('pot_size')->nullable();
            $table->string('pot_type')->nullable();
            $table->string('health_status')->nullable();
            $table->string('location')->nullable();
            $table->string('light_requirement')->nullable();
            $table->timestamp('last_watered_at')->nullable();
            $table->timestamp('last_fertilized_at')->nullable();
            $table->timestamp('last_pruned_at')->nullable();
            $table->timestamp('last_repotted_at')->nullable();
            $table->string('watering_frequency')->nullable();
            $table->string('fertilizing_frequency')->nullable();
            $table->string('pruning_frequency')->nullable();
            $table->string('repotting_frequency')->nullable();
            $table->decimal('acquisition_price', 15, 2)->nullable();
            $table->date('acquisition_date')->nullable();
            $table->decimal('current_value', 15, 2)->nullable();
            $table->string('status')->default('available');
            $table->string('image_path')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bonsais');
    }
};