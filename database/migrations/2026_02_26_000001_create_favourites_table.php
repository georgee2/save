<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favourites', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 120)->index();
            $table->string('item_type', 20);
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('emirate_id')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('sales_agent_id')->nullable();
            $table->boolean('is_permanent')->default(false);
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamps();

            $table->unique(['session_id', 'item_type', 'item_id'], 'fav_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favourites');
    }
};
