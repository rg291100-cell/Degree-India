<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('booking_slots', function (Blueprint $table) {
            $table->id();
            $table->string('slot_time')->unique(); // e.g., "7:00 AM - 8:00 AM"
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_active')->default(true);
            $table->integer('max_bookings')->default(1);
            $table->integer('current_bookings')->default(0);
            $table->json('days_available')->nullable(); // ['monday', 'tuesday', ...]
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_slots');
    }
};