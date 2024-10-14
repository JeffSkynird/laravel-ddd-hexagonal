<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendInvoiceCreatedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    public function handle(InvoiceCreated $event)
    {
       /*  Mail::raw(
            "Your invoice with ID {$event->invoiceId} has been created.",
            function ($message) use ($event) {
                $message->to($event->customerEmail)->subject('Invoice Created');
            }
        ); */
        Log::info("Invoice created with ID {$event->invoiceId}");
    }
}
