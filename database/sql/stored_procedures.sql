-- Stored Procedures for Jamin Application

-- SP 1: Get all Leveranciers with count of unique products
DELIMITER $$
CREATE PROCEDURE sp_GetLeveranciersWithProductCount()
BEGIN
    SELECT 
        l.Id,
        l.Naam,
        l.ContactPersoon,
        l.LeverancierNummer,
        l.Mobiel,
        COUNT(DISTINCT ppl.ProductId) AS AantalVerschillendeProducten
    FROM Leverancier l
    LEFT JOIN ProductPerLeverancier ppl ON l.Id = ppl.LeverancierId
    WHERE l.IsActief = 1
    GROUP BY l.Id, l.Naam, l.ContactPersoon, l.LeverancierNummer, l.Mobiel
    ORDER BY AantalVerschillendeProducten DESC;
END$$
DELIMITER ;

-- SP 2: Get products delivered by a specific supplier
DELIMITER $$
CREATE PROCEDURE sp_GetProductsByLeverancier(IN p_LeverancierId INT)
BEGIN
    SELECT 
        ppl.Id,
        p.Id AS ProductId,
        p.Naam,
        p.Barcode,
        m.AantalAanwezig,
        MAX(ppl.DatumLevering) AS LaatsteAanlevering
    FROM ProductPerLeverancier ppl
    JOIN Product p ON ppl.ProductId = p.Id
    LEFT JOIN Magazijn m ON p.Id = m.ProductId
    WHERE ppl.LeverancierId = p_LeverancierId
    AND p.IsActief = 1
    GROUP BY ppl.Id, p.Id, p.Naam, p.Barcode, m.AantalAanwezig
    ORDER BY m.AantalAanwezig DESC;
END$$
DELIMITER ;

-- SP 3: Add new delivery and update magazine stock
DELIMITER $$
CREATE PROCEDURE sp_AddDeliveryAndUpdateStock(
    IN p_LeverancierId INT,
    IN p_ProductId INT,
    IN p_AantalProducteenheden INT,
    IN p_DatumEerstVolgendeLevering DATE,
    OUT p_Success BIT,
    OUT p_Message VARCHAR(255)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SET p_Success = 0;
        SET p_Message = 'Database error occurred';
    END;

    -- Check if product is active
    IF (SELECT IsActief FROM Product WHERE Id = p_ProductId) = 0 THEN
        SET p_Success = 0;
        SET p_Message = CONCAT('Het product ', (SELECT Naam FROM Product WHERE Id = p_ProductId), 
                              ' van de leverancier ', (SELECT Naam FROM Leverancier WHERE Id = p_LeverancierId),
                              ' wordt niet meer geproduceerd');
    ELSE
        -- Insert new delivery record
        INSERT INTO ProductPerLeverancier (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering)
        VALUES (p_LeverancierId, p_ProductId, CURDATE(), p_AantalProducteenheden, p_DatumEerstVolgendeLevering);
        
        -- Update magazine stock
        UPDATE Magazijn 
        SET AantalAanwezig = COALESCE(AantalAanwezig, 0) + p_AantalProducteenheden
        WHERE ProductId = p_ProductId;
        
        -- Update timestamp
        UPDATE ProductPerLeverancier 
        SET DatumGewijzigd = NOW(6)
        WHERE ProductId = p_ProductId AND LeverancierId = p_LeverancierId;
        
        SET p_Success = 1;
        SET p_Message = 'Delivery added successfully';
    END IF;
END$$
DELIMITER ;

-- SP 4: Get count of products per leverancier (for checking if empty)
DELIMITER $$
CREATE PROCEDURE sp_GetProductCountByLeverancier(IN p_LeverancierId INT, OUT p_Count INT)
BEGIN
    SELECT COUNT(DISTINCT ppl.ProductId) INTO p_Count
    FROM ProductPerLeverancier ppl
    JOIN Product p ON ppl.ProductId = p.Id
    WHERE ppl.LeverancierId = p_LeverancierId
    AND p.IsActief = 1;
END$$
DELIMITER ;

-- SP 5: Get leverancier details
DELIMITER $$
CREATE PROCEDURE sp_GetLeverancierById(IN p_LeverancierId INT)
BEGIN
    SELECT *
    FROM Leverancier
    WHERE Id = p_LeverancierId
    AND IsActief = 1;
END$$
DELIMITER ;

-- SP 6: Update product status (set IsActief)
DELIMITER $$
CREATE PROCEDURE sp_UpdateProductStatus(
    IN p_ProductId INT,
    IN p_IsActief BIT
)
BEGIN
    UPDATE Product
    SET IsActief = p_IsActief,
        DatumGewijzigd = NOW(6)
    WHERE Id = p_ProductId;
END$$
DELIMITER ;
