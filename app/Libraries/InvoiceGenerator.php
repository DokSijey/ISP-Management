<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\BillsModel;
use App\Models\SubscriberModel;
use CodeIgniter\Email\Exceptions\EmailException;

class InvoiceGenerator
{

public function generateAndSendInvoice($invoiceNumber, $emailTo)
{
    try {
        $billModel = new BillsModel();
        $subscriberModel = new SubscriberModel();

        $bill = $billModel->where('invoice_number', $invoiceNumber)->first();
        if (!$bill) return false;

        $subscriber = $subscriberModel->find($bill['subscriber_id']);
        if (!$subscriber) return false;

        $imagePath = FCPATH . 'assets/images/Logo.png';
        $base64 = '';
        if (file_exists($imagePath)) {
            $imageData = file_get_contents($imagePath);
            $mime = mime_content_type($imagePath);
            $base64 = 'data:' . $mime . ';base64,' . base64_encode($imageData);
        }

        // Billing period
        $billingDay = (int)$bill['billing_day'];
        $year = date('Y');
        $month = date('m');
        $start = date("F d, Y", strtotime("first day of previous month +$billingDay days"));
        $end = date("F d, Y", strtotime("first day of this month +$billingDay days"));
        $billDate = "$start to $end";
        $dueDate = date("F d, Y", strtotime("$year-$month-$billingDay"));

        $vat = round($bill['price_to_pay'] * 0.12, 2);
        $msf = round($bill['price_to_pay'] - $vat, 2);

        $data = [
            'bill' => [
                'invoice_number' => $bill['invoice_number'],
                'account_number' => $subscriber['account_number'],
                'account_name' => trim($subscriber['first_name'] . ' ' . $subscriber['last_name']),
                'address' => $subscriber['address'] . ', ' . $subscriber['city'],
                'amount' => $bill['price_to_pay'],
                'bill_date' => $billDate,
                'due_date' => $dueDate,
                'msf' => $msf,
                'vat' => $vat,
                'total' => $bill['price_to_pay'],
                'logo' => $base64,
            ]
        ];

        // Generate PDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('admin/finance/billing_statement', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfPath = WRITEPATH . "invoices/invoice_$invoiceNumber.pdf";
        file_put_contents($pdfPath, $dompdf->output());

        if (!file_exists($pdfPath)) {
            log_message('error', "Invoice PDF not generated at: $pdfPath");
            return false;
        }

        // Send email
        $email = \Config\Services::email();
        $email->setTo($emailTo);
        $email->setSubject('Your Billing Invoice');
        $email->setMessage('Please see the attached invoice.');
        $email->attach($pdfPath);

        if (!$email->send()) {
            log_message('error', "Email send failed. Debug info: " . print_r($email->printDebugger(['headers']), true));
            return false;
        }

        return true;

    } catch (\Throwable $e) {
        log_message('error', 'InvoiceGenerator Exception: ' . $e->getMessage());
        return false;
    }
}
}
