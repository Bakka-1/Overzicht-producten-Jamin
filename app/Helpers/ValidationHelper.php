<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class ValidationHelper
{
    /**
     * Validate product exists and is active
     */
    public static function isProductActive($productId)
    {
        $result = DB::select(
            'SELECT IsActief FROM Product WHERE Id = ?',
            [$productId]
        );

        if (empty($result)) {
            return false;
        }

        return (bool) $result[0]->IsActief;
    }

    /**
     * Validate supplier exists and is active
     */
    public static function isSupplierActive($supplierId)
    {
        $result = DB::select(
            'SELECT IsActief FROM Leverancier WHERE Id = ?',
            [$supplierId]
        );

        if (empty($result)) {
            return false;
        }

        return (bool) $result[0]->IsActief;
    }

    /**
     * Validate supplier delivers this product
     */
    public static function supplierDeliversProduct($supplierId, $productId)
    {
        $result = DB::select(
            'SELECT Id FROM ProductPerLeverancier WHERE LeverancierId = ? AND ProductId = ?',
            [$supplierId, $productId]
        );

        return !empty($result);
    }

    /**
     * Validate date format
     */
    public static function isValidDateFormat($date)
    {
        try {
            \Carbon\Carbon::parse($date);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
