<?php

namespace App\Logging;

use Illuminate\Support\Facades\Log;

class DeliveryLogger
{
    /**
     * Log delivery attempt
     */
    public static function logDeliveryAttempt($supplierId, $productId, $quantity)
    {
        Log::channel('daily')->info('Delivery attempt', [
            'supplier_id' => $supplierId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'timestamp' => now(),
            'user_ip' => request()->ip()
        ]);
    }

    /**
     * Log successful delivery
     */
    public static function logSuccessfulDelivery($supplierId, $productId, $quantity)
    {
        Log::channel('daily')->info('Delivery successful', [
            'supplier_id' => $supplierId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'timestamp' => now()
        ]);
    }

    /**
     * Log failed delivery (product not active)
     */
    public static function logFailedDelivery($supplierId, $productId, $reason)
    {
        Log::channel('daily')->warning('Delivery failed', [
            'supplier_id' => $supplierId,
            'product_id' => $productId,
            'reason' => $reason,
            'timestamp' => now()
        ]);
    }

    /**
     * Log supplier access
     */
    public static function logSupplierAccess($supplierId)
    {
        Log::channel('daily')->info('Supplier accessed', [
            'supplier_id' => $supplierId,
            'timestamp' => now(),
            'user_ip' => request()->ip()
        ]);
    }
}
