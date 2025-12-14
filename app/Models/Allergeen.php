<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Allergeen extends Model
{
    use HasFactory;

    protected $table = 'Allergeen';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Omschrijving',
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
     * Relationship to ProductPerAllergeen
     */
    public function producten()
    {
        return $this->hasMany(ProductPerAllergeen::class, 'AllergeenId', 'Id');
    }
}
