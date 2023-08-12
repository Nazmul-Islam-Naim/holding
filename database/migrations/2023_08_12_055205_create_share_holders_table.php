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
        Schema::create('share_holders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone', 15)->unique();
            $table->string('mail',30)->nullable()->unique();
            $table->string('avatar')->nullable();
            $table->string('nid')->nullable();
            $table->text('details')->nullable();
            $table->decimal('bill', 15,2)->default(0);
            $table->decimal('collection', 15,2)->default(0);
            $table->decimal('due', 15,2)->default(0);
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
        Schema::dropIfExists('share_holders');
    }
};
