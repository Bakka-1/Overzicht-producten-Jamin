<?php

namespace App\Exceptions;

use Exception;

class ProductNotActiveException extends Exception
{
    protected $productName;
    protected $supplierName;

    public function __construct($productName, $supplierName)
    {
        $this->productName = $productName;
        $this->supplierName = $supplierName;
        parent::__construct(
            "Het product {$productName} van de leverancier {$supplierName} wordt niet meer geproduceerd"
        );
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function getSupplierName()
    {
        return $this->supplierName;
    }
}

class SupplierNotFoundException extends Exception
{
    public function __construct($supplierId)
    {
        parent::__construct("Leverancier met ID {$supplierId} niet gevonden");
    }
}

class ProductNotFoundException extends Exception
{
    public function __construct($productId)
    {
        parent::__construct("Product met ID {$productId} niet gevonden");
    }
}

class InvalidDeliveryQuantityException extends Exception
{
    public function __construct()
    {
        parent::__construct("Leveringshoeveelheid moet groter dan 0 zijn");
    }
}
