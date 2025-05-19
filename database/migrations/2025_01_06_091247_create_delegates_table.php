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
        Schema::create('delegates', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('country_code')->default('966');
            $table->string('email');
            $table->string('image')->nullable();
            $table->date('birth_date');
            $table->string('password');
            $table->string('code')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('completed_info')->default(false);
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('map_desc')->nullable();
            $table->string('title')->nullable();
            $table->dateTime('code_expire')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('fcm_token')->nullable();
            $table->string('admin_code');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegates');
    }
};
