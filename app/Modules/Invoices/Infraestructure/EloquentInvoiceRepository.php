<?php

namespace App\Invoices\Infrastructure;

use App\Invoices\Application\Mappers\InvoiceMapper;
use App\Invoices\Domain\Invoice;
use App\Invoices\Domain\Interfaces\InvoiceRepositoryInterface;
use App\Invoices\Domain\InvoiceItem;
use Illuminate\Support\Facades\DB;

class EloquentInvoiceRepository implements InvoiceRepositoryInterface
{
    public function findById(int $id): ?Invoice
    {
        $invoiceData = DB::table('invoices')->where('id', $id)->first();

        if (!$invoiceData) {
            return null;
        }

        $itemsData = DB::table('invoice_items')->where('invoice_id', $id)->get();

        $itemsDTO = array_map(fn($itemData) => new InvoiceItem(
            $itemData->id,
            $itemData->product_id,
            $itemData->quantity,
            $itemData->price,
            $itemData->serie
        ), $itemsData->toArray());

        $invoice = new Invoice(
            $invoiceData->id,
            $invoiceData->account_seller_id,
            $invoiceData->account_client_id,
            $invoiceData->total,
            $invoiceData->iva,
            $invoiceData->is_active,
            $itemsDTO
        );

        return  $invoice;
    }

    public function save(Invoice $invoice): void
    {
        $invoiceDTO = InvoiceMapper::toDTO($invoice);

        if ($invoiceDTO->id) {
            DB::table('invoices')
                ->where('id', $invoiceDTO->id)
                ->update([
                    'account_seller_id' => $invoiceDTO->accountSellerId,
                    'account_client_id' => $invoiceDTO->accountClientId,
                    'total' => $invoiceDTO->total,
                    'iva' => $invoiceDTO->iva,
                    'is_active' => true
                ]);

            foreach ($invoiceDTO->items as $itemDTO) {
                DB::table('invoice_items')
                    ->updateOrInsert(
                        ['id' => $itemDTO->id],
                        [
                            'invoice_id' => $invoiceDTO->id,
                            'product_id' => $itemDTO->productId,
                            'quantity' => $itemDTO->quantity,
                            'price' => $itemDTO->price,
                            'serie' => $itemDTO->serie,
                        ]
                    );
            }
        } else {
            $invoiceId = DB::table('invoices')->insertGetId([
                'account_seller_id' => $invoiceDTO->accountSellerId,
                'account_client_id' => $invoiceDTO->accountClientId,
                'total' => $invoiceDTO->total,
                'iva' => $invoiceDTO->iva,
                'is_active' => true
            ]);

            foreach ($invoiceDTO->items as $itemDTO) {
                DB::table('invoice_items')->insert([
                    'invoice_id' => $invoiceId,
                    'product_id' => $itemDTO->productId,
                    'quantity' => $itemDTO->quantity,
                    'price' => $itemDTO->price,
                    'serie' => $itemDTO->serie,
                ]);
            }
        }
    }
}
