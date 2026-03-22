<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_information', function (Blueprint $table) {
            $table->text('confirmation_email_body_en')->nullable()->after('seo_description_arabic');
            $table->text('confirmation_email_body_ar')->nullable()->after('confirmation_email_body_en');
        });
    }

    public function down(): void
    {
        Schema::table('contact_information', function (Blueprint $table) {
            $table->dropColumn(['confirmation_email_body_en', 'confirmation_email_body_ar']);
        });
    }
};
