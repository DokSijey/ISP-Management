<?php
use Dompdf\Dompdf;
use Dompdf\Options;

function createInvoicePDF(array $invoiceData, string $invoiceNumber, string $path): bool
{
    // Pass combined data array as 'bill' so the view can use $bill['logo'], $bill['account_number'], etc.
    $html = view('admin/billing_statement', [
        'bill' => $invoiceData,
        'invoiceNumber' => $invoiceNumber,
    ]);

    // Generate PDF logic here (using your PDF library)
    // Example with Dompdf:
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Save PDF to specified path
    $output = $dompdf->output();
    if (file_put_contents($path, $output) === false) {
        return false;
    }
    return true;
}
