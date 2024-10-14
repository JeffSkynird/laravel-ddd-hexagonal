<?php

namespace App\Invoices\Application\DTOs;

class InvoiceDTO
{
    public ?int $id;
    public int $accountSellerId;
    public int $accountClientId;
    public float $total;
    public float $iva;
    public array $items;

    public function __construct(?int $id, int $accountSellerId, int $accountClientId, float $total, float $iva, array $items)
    {
        $this->id = $id;
        $this->accountSellerId = $accountSellerId;
        $this->accountClientId = $accountClientId;
        $this->total = $total;
        $this->iva = $iva;
        $this->items = $items;
    }
}
