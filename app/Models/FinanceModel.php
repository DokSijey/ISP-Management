<?php

namespace App\Models;

use CodeIgniter\Model;

class FinanceModel extends Model
{
    protected $table = 'finance_records';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'type',
        'category',
        'amount',
        'quantity',
        'record_date',
        'month_tag',
        'description',
        'created_by',
        'created_at'
    ];


    public function getMonthlyRecords($monthTag)
    {
        return $this->where('month_tag', $monthTag)->orderBy('record_date', 'DESC')->findAll();
    }

    public function getMonthlyTotal($monthTag, $type)
    {
        return $this->where('month_tag', $monthTag)
                    ->where('type', $type)
                    ->selectSum('amount')
                    ->first()['amount'] ?? 0;
    }

    public function getMonthlySummary()
    {
        return $this->select("month_tag,
                SUM(CASE WHEN type = 'revenue' THEN amount ELSE 0 END) AS total_revenue,
                SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS total_expense")
                    ->groupBy('month_tag')
                    ->orderBy('month_tag', 'DESC')
                    ->findAll();
    }

    public function getSummaryByCategoryAndType($area)
    {
        return $this->select("
                type,
                CASE
                    WHEN type = 'revenue' THEN
                        CASE
                            WHEN category LIKE '%Monthly%' THEN 'MONTHLY'
                            WHEN category LIKE '%Installation%' THEN 'INSTALLATION FEES'
                            ELSE 'OTHERS / MATERIALS SOLD'
                        END
                    WHEN type = 'expense' THEN 'MATERIALS BOUGHT AND OTHER EXPENSES'
                    ELSE 'UNKNOWN'
                END AS category_tag,
                SUM(amount) AS total_amount
            ")
            ->where('created_by', $area)
            ->groupBy('type, category_tag')
            ->orderBy('type', 'ASC')
            ->orderBy('category_tag', 'ASC')
            ->findAll();
    }
}
