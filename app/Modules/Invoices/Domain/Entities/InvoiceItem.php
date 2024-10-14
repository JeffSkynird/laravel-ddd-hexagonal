<?php

namespace App\Invoices\Domain;

use App\Exceptions\InsufficientStockException;
use App\Invoices\Domain\DTOs\InvoiceItemDTO;

class InvoiceItem
{
    private ?int $id;
    private int $productId;
    private int $quantity;
    private float $price;
    private string $serie;

    public function __construct(?int $id, int $productId, int $quantity, float $price, string $serie)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->serie = $serie;
    }

    // Valida si el producto tiene stock suficiente basado en la lógica de negocio
    public function isProductAvailable(): bool
    {
        return $this->quantity > 0;
    }

    public function increaseQuantity(int $quantity): void
    {
        $this->quantity += $quantity;
    }

    public function decreaseQuantity(int $quantity): void
    {
        if ($this->quantity - $quantity < 0) {
            throw new InsufficientStockException("No se puede reducir la cantidad por debajo de 0.");
        }
        $this->quantity -= $quantity;
    }

    public function applyDiscount(float $percentage): void
    {
        $this->price -= ($this->price * $percentage / 100);
    }

    public function applyTax(float $taxPercentage): void
    {
        $this->price += ($this->price * $taxPercentage / 100);
    }

    public function getTotalPrice(): float
    {
        return $this->quantity * $this->price;
    }

    // GETTERS
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getSerie(): string
    {
        return $this->serie;
    }
}
