<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conversation_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('counselor_id');
            $table->unsignedBigInteger('student_id');
            $table->text('summary')->nullable();
            $table->text('notes')->nullable();
            $table->json('key_points')->nullable();
            $table->string('meeting_date')->nullable();
            $table->string('meeting_time')->nullable();
            $table->string('duration')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, completed, cancelled, rescheduled
            $table->string('follow_up_date')->nullable();
            $table->text('follow_up_notes')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('counselor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['booking_id', 'counselor_id', 'student_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('conversation_summaries');
    }
};