<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'account_type')) {
                $table->enum('account_type', ['staff', 'customer'])->default('staff')->after('email');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('account_type');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('phone');
            }
            if (!Schema::hasColumn('users', 'preferred_locale')) {
                $table->string('preferred_locale', 5)->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('users', 'source')) {
                $table->enum('source', ['web', 'app', 'erp', 'admin'])->default('admin')->after('preferred_locale');
            }
            if (!Schema::hasColumn('users', 'erp_customer_id')) {
                $table->string('erp_customer_id')->nullable()->unique()->after('source');
            }
            if (!Schema::hasColumn('users', 'erp_user_id')) {
                $table->string('erp_user_id')->nullable()->after('erp_customer_id');
            }
            if (!Schema::hasColumn('users', 'password_set_at')) {
                $table->timestamp('password_set_at')->nullable()->after('erp_user_id');
            }
            if (!Schema::hasColumn('users', 'synced_at')) {
                $table->timestamp('synced_at')->nullable()->after('password_set_at');
            }
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes()->after('updated_at');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('account_type');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['account_type']);
            $table->dropColumn([
                'account_type',
                'phone',
                'is_active',
                'preferred_locale',
                'source',
                'erp_customer_id',
                'erp_user_id',
                'password_set_at',
                'synced_at',
                'deleted_at',
            ]);
        });
    }
};
