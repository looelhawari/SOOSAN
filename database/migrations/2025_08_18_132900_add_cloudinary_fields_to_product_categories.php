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
        Schema::table('product_categories', function (Blueprint $table) {
            // Only add cloudinary_public_id since icon_url and parent_id already exist
            if (!Schema::hasColumn('product_categories', 'cloudinary_public_id')) {
                $table->string('cloudinary_public_id')->nullable()->after('icon_url');
            }
            if (!Schema::hasColumn('product_categories', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('parent_id');
            }
            if (!Schema::hasColumn('product_categories', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('sort_order');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn(['cloudinary_public_id', 'sort_order', 'is_active']);
        });
    }
};
