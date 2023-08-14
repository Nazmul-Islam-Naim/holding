<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalSupplierLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_supplier_ledgers', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('local_supplier_id')->constrained('local_suppliers')->onDelete('cascade');
            $table->foreignId('bank_account_id')->nullable()->constrained('bank_accounts')->onDelete('cascade');
            $table->string('transactionable_type');
            $table->integer('transactionable_id');
            $table->date('date');
            $table->string('reason');
            $table->decimal('amount', 15,2)->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('local_supplier_ledgers');
    }
}
