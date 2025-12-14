INSERT INTO ProductPerLeverancier (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering, IsActief, DatumAangemaakt, DatumGewijzigd)
VALUES (2, 10, '2024-11-20', 50, '2024-12-20', 1, NOW(6), NOW(6));

UPDATE Product SET IsActief = 0, DatumGewijzigd = NOW(6) WHERE Id = 10;

INSERT IGNORE INTO Magazijn (ProductId, AantalAanwezig, IsActief, DatumAangemaakt, DatumGewijzigd)
VALUES (10, 0, 1, NOW(6), NOW(6));
