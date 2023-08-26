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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug');
            $table->string('location')->nullable();
            $table->string('land_owner')->nullable();
            $table->string('land_amount')->nullable();
            $table->decimal('land_cost',15,2)->default(0);
            $table->text('description')->nullable();
            $table->integer('total_share')->default(0);
            $table->string('avatar')->nullable();
            $table->string('document')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->softDeletes()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
