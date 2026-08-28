<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('store_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('store_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('qty')->default(0);
            $table->timestamps();
            $table->unique(['store_id', 'product_id']);
            $table->index(['store_id', 'qty']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_products');
    }
};
