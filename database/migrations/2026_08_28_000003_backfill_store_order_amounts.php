<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Backfill historical order items that were created before price/total were saved.
        DB::statement('UPDATE store_order_items soi INNER JOIN products p ON p.id = soi.product_id SET soi.price = CAST(COALESCE(p.price, 0) AS DECIMAL(12,2)), soi.total = CAST(COALESCE(p.price, 0) AS DECIMAL(12,2)) * soi.quantity WHERE soi.price = 0 AND soi.total = 0');

        DB::statement('UPDATE store_orders so LEFT JOIN (SELECT store_order_id, COALESCE(SUM(total), 0) AS amount FROM store_order_items GROUP BY store_order_id) soi ON soi.store_order_id = so.id SET so.subtotal = COALESCE(soi.amount, 0), so.grand_total = COALESCE(soi.amount, 0)');
    }

    public function down(): void
    {
        // Historical financial snapshots must not be removed on rollback.
    }
};
