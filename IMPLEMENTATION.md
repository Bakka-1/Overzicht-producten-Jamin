# Implementatie Gids - Opdracht 2 Jamin Magazijnbeheer

## Overzicht
Deze gids beschrijft stap voor stap hoe de twee user stories zijn geïmplementeerd met Laravel, OOP, Stored Procedures en PDO.

## Structuur

```
project/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── LeverancierController.php    (US1 - leveranciers ophalen)
│   │       └── DeliveryController.php       (US2 - zendingen toevoegen)
│   └── Models/
│       ├── Leverancier.php                 (OOP model met Eloquent)
│       ├── Product.php                     (OOP model)
│       ├── ProductPerLeverancier.php       (OOP model)
│       └── Magazijn.php                    (OOP model)
├── resources/views/
│   ├── layouts/app.blade.php              (Master layout)
│   ├── leveranciers/
│   │   ├── index.blade.php                (Wireframe-01: Leverancier overzicht)
│   │   ├── products.blade.php             (Wireframe-02: Geleverde producten)
│   │   └── no-products.blade.php          (Wireframe-03: Geen producten)
│   └── deliveries/
│       ├── create.blade.php               (Wireframe-04: Zending toevoegen)
│       └── error.blade.php                (Wireframe-04 variant: Product niet actief)
├── database/sql/
│   ├── create_schema.sql                  (6 tabellen + relaties + systeemvelden)
│   ├── insert_data.sql                    (Test data)
│   └── stored_procedures.sql              (6 SPs)
└── routes/web.php                         (Routes voor beide user stories)
```

## Implementatie Stappen

### Stap 1: Database Schema Aanmaken

**Tabellen (met systeemvelden IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd):**
1. `Leverancier` - Leveranciers informatie
2. `Product` - Producten
3. `Allergeen` - Allergenen
4. `ProductPerAllergeen` - Relatie product-allergeen
5. `ProductPerLeverancier` - Leveringen van leveranciers
6. `Magazijn` - Voorraadinformatie

**Vreemde sleutels (Foreign Keys):**
- ProductPerAllergeen → Product & Allergeen
- ProductPerLeverancier → Leverancier & Product
- Magazijn → Product

### Stap 2: Stored Procedures (Verplicht!)

6 procedures aangemaakt:
1. `sp_GetLeveranciersWithProductCount()` - Alle leveranciers met product count (gesorteerd aflopend)
2. `sp_GetProductsByLeverancier(id)` - Producten per leverancier
3. `sp_AddDeliveryAndUpdateStock(...)` - Voeg zending toe + update magazijn
4. `sp_GetProductCountByLeverancier(id)` - Aantal producten per leverancier
5. `sp_GetLeverancierById(id)` - Leverancier details
6. `sp_UpdateProductStatus(id, status)` - Zet product status (IsActief)

### Stap 3: Models (OOP)

Alle modellen erven van `Illuminate\Database\Eloquent\Model`:
- Relaties tussen modellen gedefinieerd
- Casts voor data types
- Methoden voor stored procedure oproepen

```php
// Voorbeeld: Leverancier model
public static function getLeveranciersWithProductCount()
{
    return DB::select('CALL sp_GetLeveranciersWithProductCount()');
}
```

### Stap 4: Controllers met Business Logic

**LeverancierController:**
- `index()` - Toon alle leveranciers (USE SP1)
- `showProducts($id)` - Toon producten van leverancier (USE SP2 & SP4)

**DeliveryController:**
- `create()` - Toon form voor zending
- `store()` - Voeg zending toe (USE SP3) + validatie IsActief

### Stap 5: Blade Views (Wireframes)

Wireframe-01: `leveranciers/index.blade.php`
- Tabel met leveranciers
- Kolom: Naam, ContactPersoon, LeverancierNummer, Mobiel, AantalVerschillendeProducten
- Knop (📦) om producten te bekijken

Wireframe-02: `leveranciers/products.blade.php`
- Tabel met geleverde producten
- Kolom: Naam, Barcode, AantalInMagazijn, LaatsteAanlevering
- Knop (➕) om zending toe te voegen

Wireframe-03: `leveranciers/no-products.blade.php`
- Bericht: "Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin"
- Auto-redirect na 3 seconden

Wireframe-04: `deliveries/create.blade.php`
- Form met velden: AantalProducteenheden, DatumEerstVolgendeLevering
- Submit button

Wireframe-04 Error: `deliveries/error.blade.php`
- Foutbericht als product niet actief is (IsActief = 0)
- Auto-redirect na 4 seconden

### Stap 6: Routes

```php
Route::get('/leveranciers', [LeverancierController::class, 'index'])->name('leveranciers.index');
Route::get('/leveranciers/{id}/products', [LeverancierController::class, 'showProducts'])->name('leveranciers.products');
Route::get('/deliveries/create/{leverancier_id}/{product_id}', [DeliveryController::class, 'create'])->name('deliveries.create');
Route::post('/deliveries', [DeliveryController::class, 'store'])->name('deliveries.store');
```

## User Story 1: Overzicht Leveranciers

### Scenario 1: ✅ Succesvol
1. Login (niet implementeerd, maar assumed)
2. Klik "Overzicht Leveranciers" op homepage
3. Zie Wireframe-01 met alle leveranciers + product counts
4. Klik 📦 op Venco
5. Zie Wireframe-02 met producten van Venco
6. Data komt van SP2 (GetProductsByLeverancier)

### Scenario 2: ✅ Geen producten
1. Login (niet implementeerd)
2. Klik "Overzicht Leveranciers"
3. Zie Wireframe-01
4. Klik 📦 op Quality Street (Id=6, geen producten)
5. SP4 geeft 0 producten terug
6. Zie Wireframe-03 bericht
7. Auto-redirect na 3 seconden naar Wireframe-01

## User Story 2: Toevoegen Producten (Zendingen)

### Scenario 1: ✅ Succesvol toevoegen
1. Navigeer naar leverancier Venco (Wireframe-01 → 📦)
2. Zie Wireframe-02
3. Klik ➕ op "Mintnopjes"
4. Zie Wireframe-04 form
5. Vul in:
   - Aantal producteenheden: 25
   - Datum eerstvolgende levering: 29-05-2024
6. Klik "Sla op"
7. SP3 voert uit:
   - Voeg record toe in ProductPerLeverancier
   - Update Magazijn.AantalAanwezig (+25)
   - Success = 1
8. Redirect naar Wireframe-02
9. Product toont nu "+25" en datum is geupdate

### Scenario 2: ❌ Product niet actief
1. Navigeer naar leverancier Basset (Wireframe-01 → 📦)
2. Zie Wireframe-02
3. Klik ➕ op "Winegums" (IsActief = 0)
4. Zie Wireframe-04 form
5. Vul in:
   - Aantal: 30
   - Datum: vandaag
6. Klik "Sla op"
7. SP3 controleert: Product.IsActief = 0
8. Retourneert: "Het product Winegums van de leverancier Basset wordt niet meer geproduceerd"
9. Toon Wireframe-04 Error view
10. Auto-redirect na 4 seconden naar Wireframe-02

## Technologieën Gebruikt ✓

- **MVC Framework**: Laravel 11
- **OOP**: Eloquent Models, Controllers, Relationships
- **Stored Procedures**: 6 procedures (PDO & DB::select)
- **Database**: MySQL met Foreign Keys & systeemvelden
- **Views**: Blade templates
- **Routing**: Laravel route definitions

## Database Setup (PhpMyAdmin)

1. Maak database `laravel` aan
2. Execute `database/sql/create_schema.sql`
3. Execute `database/sql/insert_data.sql`
4. Execute `database/sql/stored_procedures.sql`

## Starten

```bash
php artisan serve
```

Bezoek: http://127.0.0.1:8000

## Git Commits

- Initial commit (project setup)
- Add database schema, seed data, and stored procedures
- Add models, controllers, views and routes for User Story 1
- Add database setup instructions
- Add error handling for delivery creation (US2 Scenario 2)
- (meer commits beschikbaar in branches)

## Todo voor Testen

- [ ] Database via PhpMyAdmin setup
- [ ] Laravel app starten
- [ ] User Story 1 Scenario 1 testen
- [ ] User Story 1 Scenario 2 testen
- [ ] User Story 2 Scenario 1 testen
- [ ] User Story 2 Scenario 2 testen
- [ ] Video opnemen van alle scenarios
- [ ] Push naar GitHub

---
**Status**: 5 commits ✓ | Klaar voor testen!
