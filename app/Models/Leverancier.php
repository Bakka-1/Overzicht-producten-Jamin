<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Leverancier extends Model
{
    use HasFactory;

    protected $table = 'Leverancier';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'ContactPersoon',
        'LeverancierNummer',
        'Mobiel',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd'
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime'
    ];

    /**
     * Get all leveranciers with product count using stored procedure
     */
    public static function getLeveranciersWithProductCount()
    {
        return DB::select('CALL sp_GetLeveranciersWithProductCount()');
    }

    /**
     * Get leverancier by ID
     */
    public static function getLeverancierById($id)
    {
        $result = DB::select('CALL sp_GetLeverancierById(?)', [$id]);
        return $result ? $result[0] : null;
    }

    /**
     * Relationship to ProductPerLeverancier
     */
    public function productsPerLeverancier()
    {
        return $this->hasMany(ProductPerLeverancier::class, 'LeverancierId', 'Id');
    }

    /**
     * Get active products from this leverancier
     */
    public function getActiveProducts()
    {
        return DB::select('CALL sp_GetProductsByLeverancier(?)', [$this->Id]);
    }
}
