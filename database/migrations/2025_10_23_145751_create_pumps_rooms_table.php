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
        Schema::create('pumps_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_type_id')->nullable()->constrained('project_types')->onDelete('cascade');
            $table->string('name_english');
            $table->string('name_arabic');
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pumps_rooms');
    }
};
