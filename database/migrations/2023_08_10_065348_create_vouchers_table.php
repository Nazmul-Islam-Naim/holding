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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('type_id')->constrained('types')->onDelete('cascade');
            $table->foreignId('sub_type_id')->constrained('sub_types')->onDelete('cascade');
            $table->enum('voucher_type',['Receive','Payment']);
            $table->string('bearer', 191)->nullable();
            $table->decimal('amount',15,2)->default(0);
            $table->decimal('due',15,2)->default(0);
            $table->date('date')->comment('voucher date');
            $table->string('note')->nullable();
            $table->foreignId('user_id')->default(1)->comment('voucher creator id')->constrained('users')->onDelete('cascade');
            $table->softDeletes()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
