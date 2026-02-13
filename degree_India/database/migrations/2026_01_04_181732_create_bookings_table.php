<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); 
            $table->unsignedBigInteger('counselor_id')->nullable(); 
            $table->tinyInteger('month');            // 1 to 12
            $table->smallInteger('year');            // e.g. 2026
            $table->string('slot');                   // e.g. "10:00 AM - 11:00 AM"
            $table->string('language');               // e.g. "English"
            $table->timestamps();

            // Foreign key constraint, assuming users table is for students
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('counselor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
