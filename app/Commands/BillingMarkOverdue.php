<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class BillingMarkOverdue extends BaseCommand
{
    protected $group = 'billing';
    protected $name = 'billing:mark-overdue';
    protected $description = 'Mark bills as unpaid if overdue by 7 days';

    public function run(array $params)
    {
        // Load your model or service here
        $BillsModel = new \App\Models\BillsModel();

        $BillsModel->markOverdueUnpaid();  // Your custom method you wrote to mark overdue

        CLI::write('Marked overdue bills as unpaid successfully.', 'green');
    }
}
