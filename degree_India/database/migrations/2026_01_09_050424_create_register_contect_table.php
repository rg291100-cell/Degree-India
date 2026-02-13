<?php
// database/migrations/xxxx_update_register_contect_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('register_contects', function (Blueprint $table) {
            
            $table->date('date')->nullable();
            $table->string('location_image')->nullable();
            $table->string('name_image')->nullable();
            $table->string('phone_image')->nullable();
            $table->string('email_image')->nullable();
            $table->string('otp_image')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('register_contects');
    }

    
};