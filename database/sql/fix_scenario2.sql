-- Fix for User Story 2 Scenario 2: Add Winegums to Basset with inactive status

-- Voeg Winegums toe aan Basset (leverancier 2) als delivery
INSERT INTO ProductPerLeverancier (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering, IsActief, DatumAangemaakt, DatumGewijzigd)
VALUES (2, 10, '2024-11-20', 50, '2024-12-20', 1, NOW(6), NOW(6));

-- Zorg dat Winegums inactief is (IsActief = 0)
UPDATE Product SET IsActief = 0, DatumGewijzigd = NOW(6) WHERE Id = 10;

-- Zorg dat Product 10 ook in Magazijn tabel staat
INSERT IGNORE INTO Magazijn (ProductId, AantalAanwezig, IsActief, DatumAangemaakt, DatumGewijzigd)
VALUES (10, 0, 1, NOW(6), NOW(6));
