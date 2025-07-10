<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'repair_tickets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['account_number', 'subscriber_id', 'issue', 'description', 'scheduled_date', 'status', 'reason', 'created_at', 'updated_at'];

}
