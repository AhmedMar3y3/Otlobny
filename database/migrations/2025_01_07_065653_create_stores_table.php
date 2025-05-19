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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->double('rating')->default(0);
            $table->integer('number_of_ratings')->default(0);
            $table->integer('delivery_time_min')->default(30);
            $table->integer('delivery_time_max')->default(45);
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->boolean('is_active')->default(false);
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
