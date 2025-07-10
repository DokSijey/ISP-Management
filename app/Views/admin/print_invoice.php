<!DOCTYPE html>
<html>
<head>
    <title>Billing Statement</title>
        <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">

    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 30px;
            color: #000;
        }
        .header, .section-title, .acknowledgement {
            background-color:rgb(255, 0, 0);
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            width: 100%;
            border: 1px solid red;
        }

        /* Use CSS Grid for header */
       .header {
            position: relative;  /* to position children absolutely inside */
            padding-top: 20px;   /* optional spacing for header top */
            padding-bottom: 20px;
            width: 100%;
        }
        .company-info {
            line-height: 1.3;
        }
        .invoice-info {
            margin-left: 20px;
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


        .section {
            margin-top: 20px;
            width: 100%;
        }
        .details-table, .particulars-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        .details-table td {
            padding: 5px 10px;
            vertical-align: top;
        }
        .details-table td.label {
            width: 150px;
            font-weight: bold;
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
            width: 100%;
        }
        .payment-mode td {
            padding: 5px 10px;
            vertical-align: middle;
        }
        .checkbox {
            font-weight: bold;
            font-size: 16px;
            padding-left: 10px;
        }
        .acknowledgement {
            margin-top: 30px;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body onload="window.print()">

<div class="header">
    <div class="company-info">
        <div><strong>Allstartech Hotspot</strong></div>
        <div>Wireless Internet Services</div>
        <div>Sta Cruz Hagonoy Bulacan</div>
        <div>044-305-6027</div>
    </div>
    <div class="invoice-info">
        <h4> INVOICE No.: <?= esc($bill['invoice_number']) ?> </h4>
    </div>
    <div class="company-logo">
        <img src="<?= esc($bill['logo']) ?>" alt="Company Logo">
    </div>
</div>

<div class="section section-title">Statement of Account</div>

<table class="details-table">
    <tr>
        <td class="label">Statement Date:</td>
        <td><?= date('m/d/Y') // Or your dynamic statement date ?></td>
    </tr>
</table>

<div class="section section-title">BILLING INFORMATION</div>

<table class="details-table">
    <tr>
        <td class="label">Account Number:</td>
        <td><?= esc($bill['account_number']) ?></td>
    </tr>
    <tr>
        <td class="label">Account Name:</td>
        <td><?= esc($bill['account_name'])?></td>
    </tr>
    <tr>
        <td class="label">Address:</td>
        <td><?= esc($bill['address']) ?></td>
    </tr>
    <tr>
        <td class="label">Bill Date:</td>
        <td><?= esc($bill['bill_date']) ?></td>
    </tr>
    <tr>
        <td class="label">Due Date:</td>
        <td><?= esc($bill['due_date']) ?></td>
    </tr>
</table>

<table class="particulars-table">
    <tr>
        <td class="description">MSF</td>
        <td><?= number_format($bill['msf'], 2) ?></td>
    </tr>
    <tr>
        <td class="description">12% VAT</td>
        <td><?= number_format($bill['vat'], 2) ?></td>
    </tr>
</table>

<div class="total-payment">
    Total Payment: Php <?= number_format($bill['total'], 2) ?>
</div>

<table class="payment-mode">
    <tr>
        <td>Cash</td>
        <td class="checkbox"><p style="font-size: 30px;"><strong>•</strong></p></td>
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

<div class="acknowledgement">ACKNOWLEDGEMENT</div>

</body>
</html>
