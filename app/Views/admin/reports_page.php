<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap CSS (Optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

   <?= view('admin/sidebar') ?>

    <!-- Main Content -->
    <div class="container p-4">
        <h2>Welcome, Admin!</h2>
        <p>Click the button on the sidebar to generate reports.</p>
    </div>

    <!-- SweetAlert Modal Trigger Function -->
    <script>
    function showReportModal() {
        Swal.fire({
            title: 'Generate Report',
            html: 
                `<div class="list-group text-start">
                    <a href="javascript:void(0);" onclick="generateReport('subscribers')" class="list-group-item list-group-item-action">📋 Subscribers Report</a>
                    <a href="javascript:void(0);" onclick="generateReport('billing')" class="list-group-item list-group-item-action">💰 Billing Report</a>
                    <a href="javascript:void(0);" onclick="generateReport('install')" class="list-group-item list-group-item-action">🛠 Install Tickets Report</a>
                    <a href="javascript:void(0);" onclick="generateReport('repair')" class="list-group-item list-group-item-action">🔧 Repair Tickets Report</a>
                </div>`,
            showCloseButton: true,
            showConfirmButton: false,
            focusConfirm: false,
            width: 600,
            customClass: {
                popup: 'swal2-border-radius'
            }
        });
    }

    // Function to trigger report download
    function generateReport(reportType) {
        let url = '';

        // Construct URL for the report based on the report type
        switch (reportType) {
            case 'subscribers':
                url = '<?= base_url("admin/reports/subscribers") ?>';
                break;
            case 'billing':
                url = '<?= base_url("admin/reports/billing") ?>';
                break;
            case 'install':
                url = '<?= base_url("admin/reports/tickets/install") ?>';
                break;
            case 'repair':
                url = '<?= base_url("admin/reports/tickets/repair") ?>';
                break;
        }

        // Open the report URL in a new tab to trigger the download
        window.open(url, '_blank');
    }
    </script>

</body>
</html>
