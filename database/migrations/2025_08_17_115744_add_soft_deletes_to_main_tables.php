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
        // Add soft deletes to users table
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to products table
        Schema::table('products', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to product_categories table
        Schema::table('product_categories', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to owners table
        Schema::table('owners', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to sold_products table
        Schema::table('sold_products', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('owners', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('sold_products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
