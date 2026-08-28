<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('store_orders', function (Blueprint $table) {
            $table->decimal('subtotal', 12, 2)->default(0)->after('status');
            $table->decimal('grand_total', 12, 2)->default(0)->after('subtotal');
        });

        DB::table('store_orders')->where('status', 'placed')->update(['status' => '1']);
        DB::statement("ALTER TABLE store_orders MODIFY status TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT '1=Processing, 2=Delivered'");

        Schema::table('store_order_items', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->default(0)->after('quantity');
            $table->decimal('total', 12, 2)->default(0)->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('store_order_items', function (Blueprint $table) {
            $table->dropColumn(['price', 'total']);
        });

        DB::statement("ALTER TABLE store_orders MODIFY status VARCHAR(30) NOT NULL DEFAULT 'placed'");

        Schema::table('store_orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'grand_total']);
        });
    }
};
