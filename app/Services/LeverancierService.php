<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LeverancierService
{
    /**
     * Get total product count across all suppliers
     */
    public static function getTotalProductCount()
    {
        $result = DB::select('SELECT COUNT(DISTINCT ProductId) as total FROM ProductPerLeverancier');
        return $result[0]->total ?? 0;
    }

    /**
     * Get supplier with most products
     */
    public static function getSupplierWithMostProducts()
    {
        $result = DB::select('
            SELECT l.Id, l.Naam, COUNT(DISTINCT ppl.ProductId) as count
            FROM Leverancier l
            LEFT JOIN ProductPerLeverancier ppl ON l.Id = ppl.LeverancierId
            WHERE l.IsActief = 1
            GROUP BY l.Id, l.Naam
            ORDER BY count DESC
            LIMIT 1
        ');

        return !empty($result) ? $result[0] : null;
    }

    /**
     * Get supplier by ID with active check
     */
    public static function getActiveSupplierId($id)
    {
        $result = DB::select('
            SELECT Id FROM Leverancier WHERE Id = ? AND IsActief = 1
        ', [$id]);

        return !empty($result) ? $result[0]->Id : null;
    }
}
