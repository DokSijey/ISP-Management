<?php

namespace App\Controllers;

use App\Models\BillsModel;
use CodeIgniter\Controller;

class CronController extends Controller
{
    public function markOverdue()
    {
        $billsModel = new BillsModel();
        $billsModel->markOverdueUnpaid();

        return $this->response->setJSON(['status' => 'success', 'message' => 'Overdue check executed.']);
    }
}
