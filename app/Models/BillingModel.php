<?php

namespace App\Models;

use CodeIgniter\Model;

class BillingModel extends Model
{
    protected $table = 'bills';
    protected $primaryKey = 'id';

    protected $allowedFields = ['subscriber_id', 'billing_day', 'price_to_pay', 'status', 'paid_date', 'invoice_number'];

    protected $useTimestamps = false;

    protected $createdField  = 'created_at';

    // New method to get billing records filtered by subscriber's city (admin area)
    public function getBillingByArea(string $area)
    {
        return $this->select('bills.*, subscribers.city, subscribers.account_number, subscribers.name')
            ->join('subscribers', 'bills.subscriber_id = subscribers.id')
            ->where('subscribers.city', $area)
            ->findAll();
    }
}
