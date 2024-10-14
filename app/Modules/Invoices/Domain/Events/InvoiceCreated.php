<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceCreated
{
    use Dispatchable, SerializesModels;

    public string $invoiceId;
    public string $customerEmail;

    public function __construct(string $invoiceId, string $customerEmail)
    {
        $this->invoiceId = $invoiceId;
        $this->customerEmail = $customerEmail;
    }
}
