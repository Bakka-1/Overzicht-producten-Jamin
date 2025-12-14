-- Drop existing database if it exists
DROP DATABASE IF EXISTS laravel;

-- Create new database
CREATE DATABASE laravel;

-- Use the database
USE laravel;

-- Create Leverancier Table
CREATE TABLE IF NOT EXISTS Leverancier (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Naam VARCHAR(100) NOT NULL,
    ContactPersoon VARCHAR(100) NOT NULL,
    LeverancierNummer VARCHAR(20) NOT NULL UNIQUE,
    Mobiel VARCHAR(15) NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255),
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- Create Allergeen Table
CREATE TABLE IF NOT EXISTS Allergeen (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Naam VARCHAR(100) NOT NULL,
    Omschrijving VARCHAR(255),
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255),
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- Create Product Table
CREATE TABLE IF NOT EXISTS Product (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Naam VARCHAR(100) NOT NULL,
    Barcode VARCHAR(20) NOT NULL UNIQUE,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255),
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- Create Magazijn Table
CREATE TABLE IF NOT EXISTS Magazijn (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    ProductId INT NOT NULL,
    VerpakkingsEenheid DECIMAL(5,2) NOT NULL,
    AantalAanwezig INT,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255),
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (ProductId) REFERENCES Product(Id) ON DELETE CASCADE
);

-- Create ProductPerAllergeen Table
CREATE TABLE IF NOT EXISTS ProductPerAllergeen (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    ProductId INT NOT NULL,
    AllergeenId INT NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255),
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (ProductId) REFERENCES Product(Id) ON DELETE CASCADE,
    FOREIGN KEY (AllergeenId) REFERENCES Allergeen(Id) ON DELETE CASCADE
);

-- Create ProductPerLeverancier Table
CREATE TABLE IF NOT EXISTS ProductPerLeverancier (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    LeverancierId INT NOT NULL,
    ProductId INT NOT NULL,
    DatumLevering DATE NOT NULL,
    Aantal INT NOT NULL,
    DatumEerstVolgendeLevering DATE,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255),
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id) ON DELETE CASCADE,
    FOREIGN KEY (ProductId) REFERENCES Product(Id) ON DELETE CASCADE
);

-- Create Indexes for better performance
CREATE INDEX idx_Magazijn_ProductId ON Magazijn(ProductId);
CREATE INDEX idx_ProductPerAllergeen_ProductId ON ProductPerAllergeen(ProductId);
CREATE INDEX idx_ProductPerAllergeen_AllergeenId ON ProductPerAllergeen(AllergeenId);
CREATE INDEX idx_ProductPerLeverancier_LeverancierId ON ProductPerLeverancier(LeverancierId);
CREATE INDEX idx_ProductPerLeverancier_ProductId ON ProductPerLeverancier(ProductId);
