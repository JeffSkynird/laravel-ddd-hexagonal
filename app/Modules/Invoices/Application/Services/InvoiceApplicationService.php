<?php

namespace App\Invoices\Application\Services;

use App\Events\InvoiceCreated;
use App\Invoices\Application\DTOs\InvoiceDTO;
use App\Invoices\Application\Mappers\InvoiceMapper;
use App\Invoices\Domain\Interfaces\InvoiceRepositoryInterface;
use App\Invoices\Domain\Invoice;

class InvoiceApplicationService
{
    private InvoiceRepositoryInterface $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function createInvoice(InvoiceDTO $invoiceDTO): void
    {
        $invoice = InvoiceMapper::fromDTO($invoiceDTO);
        $invoice->calculateTotal();
        $invoice->calculateIva();
        $this->invoiceRepository->save($invoice);
        event(new InvoiceCreated($invoice->getId(), 'example@gmail.com'));
    }

    public function getInvoiceById(int $id): ?Invoice
    {
        return $this->invoiceRepository->findById($id);
    }
}
