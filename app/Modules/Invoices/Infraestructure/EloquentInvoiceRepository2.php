<?php

namespace App\Invoices\Infrastructure\Repositories;

use App\Invoices\Domain\Invoice;
use App\Invoices\Domain\Interfaces\InvoiceRepositoryInterface;
use App\Invoices\Infrastructure\Mappers\EloquentInvoiceMapper;
use App\Invoices\Infrastructure\Models\InvoiceItemModel;
use App\Invoices\Infrastructure\Models\InvoiceModel;

class EloquentInvoiceRepository2 implements InvoiceRepositoryInterface
{
    public function findById(int $id): ?Invoice
    {
        $invoiceModel = InvoiceModel::with('items')->find($id);

        if (!$invoiceModel) {
            return null;
        }

        return EloquentInvoiceMapper::toDomain($invoiceModel);
    }

    public function save(Invoice $invoice): void
    {
        $invoiceModel = EloquentInvoiceMapper::toEloquent($invoice);

        $invoiceModel->save();

        foreach ($invoice->getItems() as $item) {
            $itemModel = new InvoiceItemModel();
            $itemModel->invoice_id = $invoiceModel->id;
            $itemModel->product_id = $item->getProductId();
            $itemModel->quantity = $item->getQuantity();
            $itemModel->price = $item->getPrice();
            $itemModel->serie = $item->getSerie();
            $itemModel->save();
        }
    }
}
