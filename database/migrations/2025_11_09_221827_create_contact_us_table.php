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
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subject');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message');
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->enum('status', ['Pending', 'InProgress', 'Done'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_us');
    }
};
