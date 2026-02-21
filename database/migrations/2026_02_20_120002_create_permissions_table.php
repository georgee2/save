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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->string('module', 100); // e.g., 'projects', 'offers', 'users'
            $table->string('action', 50); // e.g., 'view', 'create', 'edit', 'delete', 'restore', 'force_delete'
            $table->string('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index(['module', 'action']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
