<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceHistoryModel extends Model
{
    protected $table = 'invoice_history';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'invoice_number',
        'subscriber_id',
        'billing_day',
        'price_to_pay',
        'status',
        'paid_date',
        'created_at'
    ];
}