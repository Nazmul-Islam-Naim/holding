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
        Schema::create('bill_generates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('share_holder_id')->constrained('share_holders')->onDelete('cascade');
            $table->foreignId('bill_type_id')->constrained('bill_types')->onDelete('cascade');
            $table->decimal('bill', 15,2)->default(0);
            $table->decimal('collection', 15,2)->default(0);
            $table->decimal('due', 15,2)->default(0);
            $table->date('date')->comment('bill date');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_generates');
    }
};
