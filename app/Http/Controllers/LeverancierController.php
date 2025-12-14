<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use Illuminate\Support\Facades\DB;

class LeverancierController extends Controller
{
    public function index()
    {
        $leveranciers = Leverancier::getLeveranciersWithProductCount();
        return view('leveranciers.index', compact('leveranciers'));
    }

    public function showProducts($id)
    {
        $leverancier = Leverancier::getLeverancierById($id);
        
        if (!$leverancier) {
            return redirect()->route('leveranciers.index')->with('error', 'Leverancier not found');
        }

        // Get product count
        $result = DB::select('CALL sp_GetProductCountByLeverancier(?, @p_Count)', [$id]);
        $productCount = DB::select('SELECT @p_Count as p_Count')[0]->p_Count ?? 0;

        if ($productCount == 0) {
            return view('leveranciers.no-products', compact('leverancier'));
        }

        $products = DB::select('CALL sp_GetProductsByLeverancier(?)', [$id]);
        return view('leveranciers.products', compact('leverancier', 'products'));
    }
}
