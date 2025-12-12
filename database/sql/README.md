# Database Setup Instructions

Dit zijn de SQL-scripts voor het opzetten van de Jamin-database voor opdracht 2.

## Instructies:

1. **Database aanmaken:**
   - Open PhpMyAdmin
   - Maak een nieuwe database aan met de naam: `laravel`
   - Karakter set: `utf8mb4`

2. **Schema aanmaken:**
   - Copy de inhoud van `create_schema.sql`
   - Plak dit in PhpMyAdmin SQL-editor
   - Voer het uit

3. **Data invoegen:**
   - Copy de inhoud van `insert_data.sql`
   - Plak dit in PhpMyAdmin SQL-editor
   - Voer het uit

4. **Stored Procedures aanmaken:**
   - Copy de inhoud van `stored_procedures.sql`
   - Plak dit in PhpMyAdmin SQL-editor
   - Voer het uit

## Database Inhoud:

- **Leverancier**: Informatie over leveranciers (6 records)
- **Product**: Producten (13 records)
- **Allergeen**: Allergenen (5 records)
- **ProductPerAllergeen**: Relatie tussen producten en allergenen
- **ProductPerLeverancier**: Leveringen van leveranciers
- **Magazijn**: Voorraadinformatie

## Speciale opmerkingen:

- Product met ID 10 (Winegums) heeft `IsActief = 0` voor scenario 2
- Alle tabellen hebben systeemvelden: IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd
- 6 Stored Procedures voor het ophalen en manipuleren van data
