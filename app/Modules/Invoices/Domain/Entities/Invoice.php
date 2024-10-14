<?php

namespace App\Invoices\Domain;

use App\Invoices\Domain\InvoiceItem;

class Invoice
{
    private ?int $id;
    private int $accountSellerId;
    private int $accountClientId;
    private float $total;
    private float $iva;
    private array $items;

    public function __construct(?int $id, int $accountSellerId, int $accountClientId, float $total, float $iva)
    {
        $this->id = $id;
        $this->accountSellerId = $accountSellerId;
        $this->accountClientId = $accountClientId;
        $this->total = $total;
        $this->iva = $iva;
        $this->items = []; // Inicialización del array de items
    }

    // Agrega un item a la factura si está disponible
    public function addItem(InvoiceItem $item): void
    {
        if (!$item->isProductAvailable()) {
            throw new \Exception("No hay stock suficiente para agregar este producto.");
        }
        $this->items[] = $item;
        $this->calculateTotal();
    }

    // Remueve un item basado en su ID
    public function removeItem(int $itemId): void
    {
        foreach ($this->items as $key => $item) {
            if ($item->getId() === $itemId) {
                unset($this->items[$key]);
                $this->calculateTotal(); // Actualiza el total después de remover el item
                return;
            }
        }
        throw new \Exception("Item no encontrado.");
    }

    public function applyDiscountToAllItems(float $discountPercentage): void
    {
        foreach ($this->items as $item) {
            $item->applyDiscount($discountPercentage);
        }
        $this->calculateTotal();
    }

    public function calculateTotal(): void
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotalPrice();
        }
        $this->total = $total;
    }

    // Aplica un impuesto a todos los items
    public function applyTax(float $taxPercentage): void
    {
        foreach ($this->items as $item) {
            $item->applyTax($taxPercentage);
        }
        $this->calculateTotal();
    }

    // Calcula el IVA basado en el total
    public function calculateIva(): void
    {
        $this->iva = $this->total * 0.21;
    }

    // GETTERS
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getAccountSellerId(): int
    {
        return $this->accountSellerId;
    }
    public function getAccountClientId(): int
    {
        return $this->accountClientId;
    }
    public function getTotal(): float
    {
        return $this->total;
    }
    public function getIva(): float
    {
        return $this->iva;
    }
    public function getItems(): array
    {
        return $this->items;
    }
}
