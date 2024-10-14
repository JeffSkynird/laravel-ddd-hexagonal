<?php

namespace App\Invoices\Domain\Interfaces;

use App\Invoices\Domain\Invoice;

interface InvoiceRepositoryInterface
{
    public function findById(int $id): ?Invoice;

    public function save(Invoice $invoice): void;

}
