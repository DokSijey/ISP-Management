<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriberModel extends Model
{
    protected $table = 'subscribers';
    protected $primaryKey = 'id'; // or 'id' if that's what you're using

    protected $allowedFields = [
    'application_id', 'first_name', 'middle_name', 'last_name',
    'contact_number1', 'contact_number2', 'email', 'address',
    'city', 'plan', 'account_number', 'billing_day', 'price_to_pay',
    'created_at', 'status'
];


    protected $useTimestamps = false; // or true if you have `created_at` and `updated_at` fields
}
