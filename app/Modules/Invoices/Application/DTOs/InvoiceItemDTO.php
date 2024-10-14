<?php

namespace App\Invoices\Application\DTOs;

class InvoiceItemDTO
{
    public ?int $id;
    public int $productId;
    public int $quantity;
    public float $price;
    public string $serie;

    public function __construct(?int $id, int $productId, int $quantity, float $price, string $serie)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->serie = $serie;
    }
}
