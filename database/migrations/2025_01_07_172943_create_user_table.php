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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('image')->nullable();
            $table->string('password');
            $table->date('birth_date')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('completed_info')->default(false);
            $table->boolean('is_blocked')->default(false);
            $table->boolean('is_notify')->default(false);
            $table->string('owned_referral_code');
            $table->string('used_referral_code')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('map_desc')->nullable();
            $table->string('title')->nullable();
            $table->string('code')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('fcm_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
