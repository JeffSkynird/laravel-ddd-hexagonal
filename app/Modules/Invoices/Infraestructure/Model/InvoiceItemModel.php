<?php

namespace App\Invoices\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItemModel extends Model
{
    protected $table = 'invoice_items';

    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
        'price',
        'serie',
    ];

    // Relación con la factura
    public function invoice()
    {
        return $this->belongsTo(InvoiceModel::class, 'invoice_id');
    }
}
