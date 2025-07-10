<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">

    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title>Install Requests</title>

    <link rel="stylesheet" href="<?= base_url('/assets/css/styleadmin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
</head>
<body>
<?= view('admin/sidebar') ?>
<div class="container mt-5">
    <h2 class="text-center"><?= session()->get('area') ?> Technician - Install Requests</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (empty($applications)): ?>
        <div class="alert alert-warning text-center">No Install Request</div>
    <?php else: ?>
        <table class="table table-striped table-hover table-bordered align-middle text-center">
            <thead class="table">
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Landmark</th>
                    <th>Plan</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($applications as $app): ?>
                <tr>
                    <td><?= esc($app['first_name'] . ' ' . $app['last_name']) ?></td>
                    <td><?= esc($app['contact_number1']) ?></td>
                    <td><?= esc($app['barangay'] . ' ' . $app['city'] . ', ' . $app['province']) ?></td>
                    <td><?= esc($app['landmark']) ?></td>
                    <td><span class="badge bg-primary"><?= esc($app['plan']) ?></span></td>
                    <td><?= date('F j, Y', strtotime($app['schedule_date'])) ?></td>
                    <?php
                        $status = $app['app_status'];
                        $badgeClass = 'bg-secondary';

                        if ($status === 'On-going') $badgeClass = 'bg-primary';
                        elseif ($status === 'Installed') $badgeClass = 'bg-success';
                        elseif ($status === 'Re-schedule') $badgeClass = 'bg-warning';
                        elseif ($status === 'Cancelled') $badgeClass = 'bg-danger';
                    ?>
                    <td><span class="badge <?= $badgeClass ?>"><?= esc($status) ?></span></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#reschedModal<?= $app['id'] ?>">
                            Reschedule
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Modals for Each Application -->
        <?php foreach ($applications as $app): ?>
        <div class="modal fade" id="reschedModal<?= $app['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="<?= base_url('admin/reschedule-application') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reschedule Installation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label>New Schedule Date</label>
                            <input type="text" name="schedule_date" class="form-control datepicker" required>

                            <label class="mt-2">Reason for Rescheduling</label>
                            <textarea name="app_reason" class="form-control" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Bootstrap Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Datepicker Init -->
<script>
    $(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '0d',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
</body>
</html>
