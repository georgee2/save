<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_interior_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('max_show')->default(12);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default settings row
        DB::table('home_interior_settings')->insert([
            'max_show' => 12,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_interior_settings');
    }
};
