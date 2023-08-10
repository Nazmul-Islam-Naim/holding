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
        Schema::create('voucher_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->constrained('vouchers')->onDelete('cascade');
            $table->foreignId('bank_account_id')->constrained('bank_accounts')->onDelete('cascade');
            $table->enum('voucher_type',['Receive','Payment']);
            $table->date('date')->comment('transaction date');
            $table->decimal('amount',15,2)->default(0);
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_transactions');
    }
};
