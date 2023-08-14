<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('local_supplier_id')->constrained('local_suppliers')->onDelete('cascade');
            $table->decimal('amount',15,2)->default(0);
            $table->date('date')->nullable()->comment('purchase date');
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('created_by')->default(1);
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
        Schema::dropIfExists('local_purchases');
    }
}
