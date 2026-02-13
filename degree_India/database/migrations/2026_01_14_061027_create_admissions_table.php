<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->decimal('total_fees', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('due_amount', 10, 2);
            $table->enum('payment_mode', ['online', 'offline'])->default('offline');
            $table->enum('payment_status', ['pending', 'partially_paid', 'paid'])->default('pending');
            $table->enum('admission_status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->text('remarks')->nullable();
            $table->date('admission_date');
            $table->date('payment_date')->nullable();
            $table->string('transaction_id')->nullable();
            $table->boolean('is_notified')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id', 'course_id']);
            $table->index(['admission_status', 'payment_status']);
        });

        Schema::create('admission_fee_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_mode', ['cash', 'cheque', 'bank_transfer', 'online'])->default('cash');
            $table->string('transaction_id')->nullable();
            $table->date('payment_date');
            $table->string('receipt_number')->nullable();
            $table->text('remarks')->nullable();
            $table->string('proof_document')->nullable();
            $table->foreignId('collected_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admission_fee_payments');
        Schema::dropIfExists('admissions');
    }
};