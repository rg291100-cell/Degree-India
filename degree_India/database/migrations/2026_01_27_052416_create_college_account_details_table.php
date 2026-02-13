<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('college_account_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('college_id');
            $table->string('account_holder_name');
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('ifsc_code');
            $table->string('branch_name');
            $table->enum('account_type', ['savings', 'current']);
            $table->string('micr_code')->nullable();
            $table->string('upi_id')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->string('registered_mobile')->nullable();
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('college_id')
                  ->references('id')
                  ->on('colleges')
                  ->onDelete('cascade');
                  
            // Unique constraint for college
            $table->unique('college_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('college_account_details');
    }
};