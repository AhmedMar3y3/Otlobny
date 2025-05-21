<?php

use App\Enums\OrderPayStatus;
use App\Enums\SpecialOrderType;
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
        Schema::create('special_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('type')->default(SpecialOrderType::SENDING->value);
            $table->string('description');
            $table->text('notes')->nullable();
            $table->text('instructions')->nullable();
            $table->foreignId('address_id')->nullable()->constrained()->nullOnDelete();
            $table->string('lng');
            $table->string('lat');
            $table->string('map_desc');
            $table->string('destination_notes')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->boolean('is_asap')->default(true);
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->tinyInteger('pay_type');
            $table->tinyInteger('pay_status')->default(OrderPayStatus::NOT_PAIED->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_orders');
    }
};
