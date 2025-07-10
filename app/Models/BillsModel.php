<?php

namespace App\Models;

use CodeIgniter\Model;

class BillsModel extends Model
{
    protected $table = 'bills'; // Your actual table name
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'subscriber_id', 'billing_day', 'price_to_pay', 
        'status', 'paid_date', 'invoice_number', 'created_at', 'due_date'
    ];

    // Optional: define validation rules
    protected $validationRules = [];

    // Join with subscriber details
    public function getAllWithSubscribers()
    {
        return $this->select('bills.*, subscribers.account_number, subscribers.first_name, subscribers.middle_name, subscribers.last_name')
                    ->join('subscribers', 'subscribers.id = bills.subscriber_id')
                    ->findAll();
    }



    public function getBillingByArea(string $area)
    {
    $isOverdueSQL = "
        CASE
            WHEN bills.status = 'unpaid' AND CURRENT_DATE() > bills.due_date THEN 1 ELSE 0
        END AS is_overdue
    ";

    return $this->select("bills.*, subscribers.city, subscribers.account_number, 
                          CONCAT(subscribers.first_name, ' ', subscribers.middle_name, ' ', subscribers.last_name) AS full_name,
                          $isOverdueSQL")
        ->join('subscribers', 'bills.subscriber_id = subscribers.id')
        ->where('subscribers.city', $area)
        ->findAll();
    }



public function markOverdueUnpaid()
{
    $today = date('Y-m-d');
    $sevenDaysLater = date('Y-m-d', strtotime('+7 days'));

    $sql = "
        UPDATE bills
        SET 
            status = 'unpaid',
            paid_date = NULL,
            invoice_number = NULL
        WHERE 
            status = 'paid'
            AND due_date BETWEEN ? AND ?
    ";

    $this->db->query($sql, [$today, $sevenDaysLater]);

    log_message('info', 'Auto-mark unpaid for bills due between ' . $today . ' and ' . $sevenDaysLater);
}



}
