<?php

namespace App\Controllers;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\BillsModel;

class BillingCron extends BaseCommand
{
    protected $group       = 'Billing';
    protected $name        = 'billing:markunpaid';
    protected $description = 'Auto mark bills as unpaid 7 days before due date';

    public function run(array $params)
    {
        $billsModel = new BillsModel();
        $billsModel->autoMarkUnpaid();

        CLI::write('Auto mark unpaid task executed successfully.', 'green');
    }
}
