<?php

namespace App\Invoices\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices';
    
    protected $fillable = [
        'account_seller_id',
        'account_client_id',
        'total',
        'iva',
        'is_active',
    ];

    // Relación con los items
    public function items()
    {
        return $this->hasMany(InvoiceItemModel::class, 'invoice_id');
    }
}
