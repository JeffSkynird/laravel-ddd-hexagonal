<?php

namespace App\Invoices\UI\Http\Controllers;

use App\Exceptions\InsufficientStockException;
use App\Http\Controllers\Controller;
use App\Invoices\Application\DTOs\InvoiceDTO;
use App\Invoices\Application\Services\InvoiceApplicationService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private InvoiceApplicationService $applicationService;

    public function __construct(InvoiceApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function createInvoice(Request $request)
    {
        try {
            $validated = $request->validate([
                'accountSellerId' => 'required|integer',
                'accountClientId' => 'required|integer',
                'total' => 'required|numeric',
                'iva' => 'required|numeric',
                'items' => 'required|array',
                'items.*.productId' => 'required|integer',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
            ]);
    
            $invoiceDTO = new InvoiceDTO(
                null,
                $validated['accountSellerId'],
                $validated['accountClientId'],
                $validated['total'],
                $validated['iva'],
                $validated['items']
            );
    
            $this->applicationService->createInvoice($invoiceDTO);
            return response()->json(['message' => 'Invoice created successfully'], 201);
        }catch (InsufficientStockException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
