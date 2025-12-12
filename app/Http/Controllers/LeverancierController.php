<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use Illuminate\Support\Facades\DB;

class LeverancierController extends Controller
{
    /**
     * Show all leveranciers with product count
     */
    public function index()
    {
        $leveranciers = Leverancier::getLeveranciersWithProductCount();
        return view('leveranciers.index', compact('leveranciers'));
    }

    /**
     * Show products from a specific leverancier
     */
    public function showProducts($id)
    {
        $leverancier = Leverancier::getLeverancierById($id);
        
        if (!$leverancier) {
            return redirect()->route('leveranciers.index')->with('error', 'Leverancier not found');
        }

        // Get product count
        $result = DB::select('CALL sp_GetProductCountByLeverancier(?)', [$id]);
        $productCount = $result[0]->p_Count ?? 0;

        if ($productCount == 0) {
            // No products - show empty message
            return view('leveranciers.no-products', compact('leverancier'));
        }

        // Get products
        $products = DB::select('CALL sp_GetProductsByLeverancier(?)', [$id]);
        return view('leveranciers.products', compact('leverancier', 'products'));
    }
}
