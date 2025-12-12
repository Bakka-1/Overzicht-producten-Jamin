<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPerLeverancier extends Model
{
    use HasFactory;

    protected $table = 'ProductPerLeverancier';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'LeverancierId',
        'ProductId',
        'DatumLevering',
        'Aantal',
        'DatumEerstVolgendeLevering',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd'
    ];

    protected $casts = [
        'DatumLevering' => 'date',
        'DatumEerstVolgendeLevering' => 'date',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime'
    ];

    /**
     * Relationship to Leverancier
     */
    public function leverancier()
    {
        return $this->belongsTo(Leverancier::class, 'LeverancierId', 'Id');
    }

    /**
     * Relationship to Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }
}
