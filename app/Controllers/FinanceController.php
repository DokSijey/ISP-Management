<?php

namespace App\Controllers;

use App\Models\FinanceModel;
use CodeIgniter\Controller;

class Finance extends BaseController
{
    public function index()
    {
        $model = new FinanceModel();
        $data['records'] = $model->orderBy('record_date', 'DESC')->findAll();
        return view('finance/index', $data);
    }

    public function createRecord()
{
    helper('form');

    if ($this->request->getMethod() === 'post') {
        $type = $this->request->getPost('type'); // revenue or expenses
        $data = [
            'type' => $type,
            'source' => $this->request->getPost('source'),
            'amount' => $this->request->getPost('amount'),
            'date' => $this->request->getPost('date'),
            'remarks' => $this->request->getPost('remarks'),
        ];

        $this->financeModel->insertRecord($data);

        return redirect()->to("/finance/{$type}")->with('success', ucfirst($type) . ' created successfully');
    }

    // Default to revenue for the form type if none passed
    $type = $this->request->getGet('type') ?? 'revenue';

    return view('finance/create_record', ['type' => $type]);
}

    public function save()
    {
        $model = new FinanceModel();
        $record_date = $this->request->getPost('record_date');
        $month_tag = date('Y-m', strtotime($record_date));

        $model->save([
            'record_date' => $record_date,
            'month_tag' => $month_tag,
            'type' => $this->request->getPost('type'),
            'category' => $this->request->getPost('category'),
            'description' => $this->request->getPost('description'),
            'amount' => $this->request->getPost('amount'),
            'created_by' => session()->get('username') ?? 'admin'
        ]);

        return redirect()->to('/finance');
    }

    public function monthlyReport()
    {
        $model = new FinanceModel();
        $monthTag = $this->request->getGet('month') ?? date('Y-m');

        $data['monthTag'] = $monthTag;
        $data['records'] = $model->getMonthlyRecords($monthTag);
        $data['totalRevenue'] = $model->getMonthlyTotal($monthTag, 'revenue');
        $data['totalExpenses'] = $model->getMonthlyTotal($monthTag, 'expense');

        return view('finance/monthly_report', $data);
    }
}
