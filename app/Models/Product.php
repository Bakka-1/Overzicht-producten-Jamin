<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $table = 'Product';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Barcode',
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
     * Relationship to Magazijn
     */
    public function magazijn()
    {
        return $this->hasOne(Magazijn::class, 'ProductId', 'Id');
    }

    /**
     * Relationship to ProductPerAllergeen
     */
    public function allergenen()
    {
        return $this->hasMany(ProductPerAllergeen::class, 'ProductId', 'Id');
    }

    /**
     * Relationship to ProductPerLeverancier
     */
    public function leveranciers()
    {
        return $this->hasMany(ProductPerLeverancier::class, 'ProductId', 'Id');
    }
}
