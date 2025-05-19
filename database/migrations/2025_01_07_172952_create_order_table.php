<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\OrderStatus;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('delegate_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('order_num');
            $table->string('lat');
            $table->string('lng');
            $table->string('map_desc');
            $table->string('title');
            $table->decimal('price');
            $table->decimal('delivery_price');
            $table->decimal('total_price');
            $table->tinyInteger('status')->default(OrderStatus::PREPARING->value);
            $table->tinyInteger('pay_type');
            $table->tinyInteger('pay_status')->default(0);
            $table->boolean('is_accepted')->default(false);
            $table->foreignId('store_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
