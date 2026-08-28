<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('store_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('store_id');
            $table->unsignedInteger('pos_user_id');
            $table->string('order_number', 50)->unique();
            $table->string('status', 30)->default('placed');
            $table->timestamps();
            $table->index(['store_id', 'created_at']);
        });

        Schema::create('store_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_order_id');
            $table->unsignedInteger('product_id');
            $table->string('product_name');
            $table->unsignedInteger('quantity');
            $table->timestamps();
            $table->index('store_order_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_order_items');
        Schema::dropIfExists('store_orders');
    }
};
