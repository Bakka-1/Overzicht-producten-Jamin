<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPerAllergeen extends Model
{
    use HasFactory;

    protected $table = 'ProductPerAllergeen';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'ProductId',
        'AllergeenId',
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
     * Relationship to Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }

    /**
     * Relationship to Allergeen
     */
    public function allergeen()
    {
        return $this->belongsTo(Allergeen::class, 'AllergeenId', 'Id');
    }
}
