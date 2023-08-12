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
        Schema::create('project_shareholders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_share_id')->constrained('project_shares')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('share_holder_id')->constrained('share_holders')->onDelete('cascade');
            $table->foreignId('bank_account_id')->nullable()->constrained('bank_accounts')->onDelete('cascade');
            $table->tinyInteger('transaction_type')->comment('7 = bill, 5 = receive/collection');
            $table->decimal('amount', 15,2)->default(0);
            $table->date('date')->comment('bill/collection/receive');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_shareholders');
    }
};
