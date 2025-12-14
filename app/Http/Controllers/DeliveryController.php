<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    /**
     * Show form to add new delivery
     */
    public function create($leverancierId, $productId)
    {
        $leverancier = Leverancier::find($leverancierId);
        $product = Product::find($productId);

        if (!$leverancier || !$product) {
            return redirect()->back()->with('error', 'Leverancier or Product not found');
        }

        return view('deliveries.create', compact('leverancier', 'product'));
    }

    /**
     * Store new delivery
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'leverancier_id' => 'required|integer|exists:Leverancier,Id',
            'product_id' => 'required|integer|exists:Product,Id',
            // Prevent oversized integers that overflow MySQL INT (max ~2.1B)
            'aantal_producteenheden' => 'required|integer|min:1|max:2000000000',
            'datum_eerstvolgende_levering' => 'required|date'
        ]);

        $leverancier_id = $validated['leverancier_id'];
        $product_id = $validated['product_id'];
        $aantal = $validated['aantal_producteenheden'];
        $datum = $validated['datum_eerstvolgende_levering'];

        // Call stored procedure
        $success = false;
        $message = '';

        DB::statement('CALL sp_AddDeliveryAndUpdateStock(?, ?, ?, ?, @success, @message)', 
            [$leverancier_id, $product_id, $aantal, $datum]
        );

        $result = DB::select('SELECT @success as success, @message as message');
        $success = $result[0]->success;
        $message = $result[0]->message;

        if ($success) {
            return redirect()->route('leveranciers.products', $leverancier_id)
                ->with('success', 'Zending succesvol toegevoegd');
        } else {
            // Return to delivery form with error, but with redirect after 4 seconds
            return view('deliveries.error', [
                'message' => $message,
                'leverancier_id' => $leverancier_id
            ]);
        }
    }
}
