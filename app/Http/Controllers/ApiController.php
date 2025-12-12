<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * Get leveranciers as JSON
     */
    public function getLeveranciers(): JsonResponse
    {
        try {
            $leveranciers = Leverancier::getLeveranciersWithProductCount();
            return response()->json([
                'success' => true,
                'data' => $leveranciers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching suppliers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get products by leverancier as JSON
     */
    public function getProductsByLeverancier($id): JsonResponse
    {
        try {
            $leverancier = Leverancier::getLeverancierById($id);
            
            if (!$leverancier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Supplier not found'
                ], 404);
            }

            $products = DB::select('CALL sp_GetProductsByLeverancier(?)', [$id]);
            
            return response()->json([
                'success' => true,
                'supplier' => $leverancier,
                'products' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get product stock
     */
    public function getProductStock($productId): JsonResponse
    {
        try {
            $result = DB::select(
                'SELECT AantalAanwezig FROM Magazijn WHERE ProductId = ?',
                [$productId]
            );

            if (empty($result)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'stock' => $result[0]->AantalAanwezig ?? 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
