<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DeliveryService
{
    /**
     * Validate if a product can receive a delivery
     */
    public static function canReceiveDelivery($productId)
    {
        $product = DB::select('SELECT IsActief FROM Product WHERE Id = ?', [$productId]);
        
        if (empty($product)) {
            return false;
        }

        return (bool) $product[0]->IsActief;
    }

    /**
     * Get formatted product name with supplier
     */
    public static function getFormattedProductName($productId, $supplierId)
    {
        $result = DB::select('
            SELECT p.Naam, l.Naam as LeverancierNaam 
            FROM Product p 
            JOIN ProductPerLeverancier ppl ON p.Id = ppl.ProductId
            JOIN Leverancier l ON ppl.LeverancierId = l.Id
            WHERE p.Id = ? AND l.Id = ?
        ', [$productId, $supplierId]);

        if (empty($result)) {
            return null;
        }

        return [
            'product' => $result[0]->Naam,
            'leverancier' => $result[0]->LeverancierNaam
        ];
    }

    /**
     * Get current stock for a product
     */
    public static function getCurrentStock($productId)
    {
        $result = DB::select('SELECT AantalAanwezig FROM Magazijn WHERE ProductId = ?', [$productId]);
        
        if (empty($result)) {
            return 0;
        }

        return $result[0]->AantalAanwezig ?? 0;
    }
}
