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
        Schema::create('service_section_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->string('section_type'); // 'features', 'main_info', 'description', 'values', 'process', 'faq', 'custom_block'
            $table->unsignedBigInteger('section_id')->nullable(); // For custom blocks (references service_blocks.id), null for standard sections
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true); // Show/hide section
            $table->timestamps();
            
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            
            // Ensure unique combination of service_id, section_type, and section_id
            $table->unique(['service_id', 'section_type', 'section_id'], 'unique_section_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_section_orders');
    }
};
