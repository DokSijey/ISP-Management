<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
        <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">
    <title>Billing Statement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 30px;
            color: #000;
        }
        .header, .section-title, .acknowledgement {
            background-color: rgb(255, 0, 0);
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            border: 1px solid red;
            width: 100%;
            box-sizing: border-box;
        }
        .header {
            position: relative;
            padding: 20px 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .company-info {
            line-height: 1.3;
        }
        .invoice-info h4 {
            margin: 0;
            white-space: nowrap;
        }
        .company-logo {
            position: absolute;
            top: 10;
            right: 15;
            max-width: 150px;
        }
        .company-logo img {
            max-width: 120px;
            height: auto;
            top: 10px;
            display: block; /* block removes bottom space */
        }
        .section-title {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            box-sizing: border-box;
        }
        .details-table td.label {
            width: 160px;
            font-weight: bold;
            padding: 5px 10px;
            vertical-align: top;
        }
        .details-table td {
            padding: 5px 10px;
            vertical-align: top;
        }
        .particulars-table th, .particulars-table td {
            border: 1px solid #ccc;
            padding: 5px 10px;
            text-align: right;
        }
        .particulars-table th.description, .particulars-table td.description {
            text-align: left;
        }
        .total-payment {
            margin-top: 10px;
            font-weight: bold;
            text-align: right;
        }
        .payment-mode {
            margin-top: 20px;
        }
        .payment-mode td {
            padding: 5px 10px;
            vertical-align: middle;
        }
        .checkbox {
            font-weight: bold;
            font-size: 30px;
            padding-left: 10px;
            text-align: center;
            width: 30px;
        }
        .acknowledgement {
            margin-top: 30px;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="company-info" aria-label="Company information">
        <div><strong>Allstartech Hotspot</strong></div>
        <div>Wireless Internet Services</div>
        <div>Sta Cruz Hagonoy Bulacan</div>
        <div>044-305-6027</div>
    </div>

    <div class="invoice-info" aria-label="Invoice number">
        <h4>INVOICE No.: <?= esc($bill['invoice_number'] ?? 'N/A') ?></h4>
    </div>

    <div class="company-logo" aria-label="Company logo">
        <?php if (!empty($bill['logo'])): ?>
            <img src="<?= esc($bill['logo']) ?>" alt="Company Logo">
        <?php else: ?>
            <img src="<?= esc(base_url('assets/images/Logo.png')) ?>" alt="Company Logo">
        <?php endif; ?>
    </div>
</div>

<div class="section section-title" role="heading" aria-level="2">Statement of Account</div>

<table class="details-table" aria-label="Statement date">
    <tr>
        <td class="label">Statement Date:</td>
        <td><?= date('m/d/Y') ?></td>
    </tr>
</table>

<div class="section section-title" role="heading" aria-level="2">BILLING INFORMATION</div>

<table class="details-table" aria-label="Billing information">
    <tr>
        <td class="label">Account Number:</td>
        <td><?= esc($bill['account_number'] ?? 'N/A') ?></td>
    </tr>
    <tr>
        <td class="label">Account Name:</td>
        <td><?= esc($bill['account_name'] ?? 'N/A') ?></td>
    </tr>
    <tr>
        <td class="label">Address:</td>
        <td><?= esc($bill['address'] ?? 'N/A') ?></td>
    </tr>
    <tr>
        <td class="label">Bill Date:</td>
        <td><?= esc($bill['bill_date'] ?? 'N/A') ?></td>
    </tr>
    <tr>
        <td class="label">Due Date:</td>
        <td><?= esc($bill['due_date'] ?? 'N/A') ?></td>
    </tr>
</table>

<table class="particulars-table" aria-label="Billing particulars">
    <tr>
        <td class="description">MSF</td>
        <td><?= number_format($bill['msf'] ?? 0, 2) ?></td>
    </tr>
    <tr>
        <td class="description">12% VAT</td>
        <td><?= number_format($bill['vat'] ?? 0, 2) ?></td>
    </tr>
</table>

<div class="total-payment">
    Total Payment: Php <?= number_format($bill['total'] ?? 0, 2) ?>
</div>

<table class="payment-mode" aria-label="Payment mode options">
    <tr>
        <td>Cash</td>
        <td class="checkbox">&#8226;</td>
        <td>Bank transfer</td>
        <td></td>
    </tr>
    <tr>
        <td>Gcash</td>
        <td></td>
        <td>Others</td>
        <td></td>
    </tr>
</table>

<div class="acknowledgement" role="contentinfo">ACKNOWLEDGEMENT</div>

</body>
</html>
