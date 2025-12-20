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
        Schema::create('offer_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->foreignId('emirate_id')->constrained('emirates')->onDelete('cascade');
            $table->decimal('price', 15, 2);
            $table->string('notes_english')->nullable();
            $table->string('notes_arabic')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0: Active, 1: Inactive');
            $table->softDeletes();
            $table->timestamps();
            
            // Unique constraint: One price per emirate per offer
            $table->unique(['offer_id', 'emirate_id', 'deleted_at'], 'unique_offer_emirate_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_prices');
    }
};

