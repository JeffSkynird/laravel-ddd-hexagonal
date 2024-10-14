<?php

namespace App\Invoices\Infrastructure\Mappers;

use App\Invoices\Domain\Invoice;
use App\Invoices\Domain\InvoiceItem;
use App\Invoices\Infrastructure\Models\InvoiceModel;

class EloquentInvoiceMapper
{
    /**
     * Convierte de un modelo de Eloquent a una entidad de dominio (Invoice)
     *
     * @param InvoiceModel $invoiceModel
     * @return Invoice
     */
    public static function toDomain(InvoiceModel $invoiceModel): Invoice
    {
        // Crear la entidad de dominio Invoice
        $invoice = new Invoice(
            $invoiceModel->id,
            $invoiceModel->account_seller_id,
            $invoiceModel->account_client_id,
            $invoiceModel->total,
            $invoiceModel->iva,
            $invoiceModel->is_active
        );

        // Mapear los items desde Eloquent a las entidades de dominio
        foreach ($invoiceModel->items as $itemModel) {
            $invoiceItem = new InvoiceItem(
                $itemModel->id,
                $itemModel->product_id,
                $itemModel->quantity,
                $itemModel->price,
                $itemModel->serie
            );
            $invoice->addItem($invoiceItem); // Añadir cada item a la factura
        }

        return $invoice; // Devolver la entidad de dominio completa
    }

    /**
     * Convierte de una entidad de dominio (Invoice) a un modelo de Eloquent (InvoiceModel)
     *
     * @param Invoice $invoice
     * @return InvoiceModel
     */
    public static function toEloquent(Invoice $invoice): InvoiceModel
    {
        // Si ya existe en la base de datos, lo buscamos. Si no, creamos un nuevo modelo
        $invoiceModel = $invoice->getId() ? InvoiceModel::find($invoice->getId()) : new InvoiceModel();

        // Asignar las propiedades de la entidad de dominio al modelo de Eloquent
        $invoiceModel->account_seller_id = $invoice->getAccountSellerId();
        $invoiceModel->account_client_id = $invoice->getAccountClientId();
        $invoiceModel->total = $invoice->getTotal();
        $invoiceModel->iva = $invoice->getIva();
        $invoiceModel->is_active = true;

        return $invoiceModel; // Devolver el modelo de Eloquent
    }
}
