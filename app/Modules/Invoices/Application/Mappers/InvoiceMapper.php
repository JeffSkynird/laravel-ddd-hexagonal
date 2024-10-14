<?php

namespace App\Invoices\Application\Mappers;

use App\Invoices\Application\DTOs\InvoiceDTO;
use App\Invoices\Application\DTOs\InvoiceItemDTO;
use App\Invoices\Domain\Invoice;
use App\Invoices\Domain\InvoiceItem;

class InvoiceMapper
{
    public static function toDTO(Invoice $invoice): InvoiceDTO
    {
        $itemsDTO = array_map(fn(InvoiceItem $item) => new InvoiceItemDTO(
            $item->getId(),
            $item->getProductId(),
            $item->getQuantity(),
            $item->getPrice(),
            $item->getSerie()
        ), $invoice->getItems());

        return new InvoiceDTO(
            $invoice->getId(),
            $invoice->getAccountSellerId(),
            $invoice->getAccountClientId(),
            $invoice->getTotal(),
            $invoice->getIva(),
            $itemsDTO
        );
    }

    public static function fromDTO(InvoiceDTO $dto): Invoice
    {
        $items = array_map(fn(InvoiceItemDTO $itemDTO) => new InvoiceItem(
            $itemDTO->id,
            $itemDTO->productId,
            $itemDTO->quantity,
            $itemDTO->price,
            $itemDTO->serie
        ), $dto->items);

        $invoice = new Invoice(
            $dto->id,
            $dto->accountSellerId,
            $dto->accountClientId,
            $dto->total,
            $dto->iva
        );
        $invoice->addItem(...$items);
        return $invoice;
    }
}
