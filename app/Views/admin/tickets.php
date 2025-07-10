<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">

    <meta name="csrf-token" content="<?= csrf_hash() ?>" />
    <title>Tickets Management</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css"
      rel="stylesheet"
    />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
      /* WebKit browsers (Chrome, Safari, Edge) */
::-webkit-scrollbar {
  width: 10px;
  height: 10px;
}

::-webkit-scrollbar-track {
  background: #1e1e1e; /* dark track */
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background-color: #4caf50; /* green thumb */
  border-radius: 10px;
  border: 2px solid #1e1e1e; /* padding around thumb */
}

::-webkit-scrollbar-thumb:hover {
  background-color: #66bb6a; /* lighter green on hover */
}

/* Firefox */
* {
  scrollbar-width: thin;
  scrollbar-color: #4caf50 #1e1e1e;
}
        /* Root colors */
    :root {
      --black: #121212;
      --dark-gray: #1e1e1e;
      --red: #dc3545;
      --red-light: #f56264;
      --text-light: #f8f9fa;
    }

    body {
      background-color: var(--black);
      color: var(--text-light);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      margin: 0;
    }

    /* Sidebar */
    #sidebar {
      background: var(--dark-gray);
      min-width: 250px;
      max-width: 250px;
      height: 100vh;
      position: fixed;
      transition: all 0.3s;
      overflow-y: auto;
      z-index: 1030;
    }

    #sidebar.collapsed {
      min-width: 70px;
      max-width: 70px;
    }

    #sidebar .nav-link {
      color: var(--text-light);
      font-weight: 500;
      padding: 15px 25px;
      transition: background-color 0.2s;
      white-space: nowrap;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    #sidebar .nav-link:hover,
    #sidebar .nav-link.active {
      background: var(--red);
      color: white;
      border-radius: 0 25px 25px 0;
    }

    #sidebar .nav-link i {
      font-size: 1.4rem;
      min-width: 24px;
      text-align: center;
    }

    #sidebar.collapsed .nav-link span.label-text {
      display: none;
    }

    /* Top Navbar */
    #top-navbar {
      height: 60px;
      background: var(--dark-gray);
      padding: 0 1.5rem;
      position: fixed;
      top: 0;
      left: 250px;
      right: 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      z-index: 1020;
      transition: left 0.3s;
    }

    #sidebar.collapsed + #top-navbar {
      left: 70px;
    }

    #top-navbar .search-input {
      max-width: 400px;
      width: 100%;
      border-radius: 20px;
      border: none;
      padding: 6px 15px;
      background-color: #2a2a2a;
      color: var(--text-light);
    }

    #top-navbar .search-input::placeholder {
      color: #aaa;
    }

    #top-navbar .nav-icons {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    #top-navbar .nav-icons i {
      font-size: 1.5rem;
      cursor: pointer;
      color: var(--text-light);
      position: relative;
    }

    #top-navbar .nav-icons .badge {
      position: absolute;
      top: -5px;
      right: -10px;
      background: var(--red);
      color: white;
      font-size: 0.6rem;
      padding: 2px 6px;
      border-radius: 50%;
    }

    #top-navbar .user-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: var(--red-light);
      color: white;
      font-weight: 700;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      user-select: none;
    }

    /* Main Content */
    #main-content {
      margin-top: 60px;
      margin-left: 250px;
      padding: 2rem;
      transition: margin-left 0.3s;
      min-height: calc(100vh - 60px);
    }

    #sidebar.collapsed ~ #main-content {
      margin-left: 70px;
    }

    /* Cards */
    .card-metric {
      border-radius: 15px;
      color: white;
      padding: 20px;
      height: 130px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 0 10px rgb(220 53 69 / 0.4);
      font-weight: 700;
      cursor: default;
      transition: transform 0.2s ease;
    }
    .card-metric:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgb(220 53 69 / 0.6);
    }
    .card-icon {
      font-size: 3rem;
      opacity: 0.8;
    }

    .bg-gradient-1 {
      background: linear-gradient(135deg, #dc3545, #b52b3c);
    }
    .bg-gradient-2 {
      background: linear-gradient(135deg, #8b0000, #dc3545);
    }
    .bg-gradient-3 {
      background: linear-gradient(135deg, #a83232, #f56264);
    }
    .bg-gradient-4 {
      background: linear-gradient(135deg, #b83232, #dc3545);
    }

    /* Chart container */
    #chart-container {
      background: var(--dark-gray);
      border-radius: 15px;
      padding: 1.5rem;
      margin-top: 2rem;
      box-shadow: 0 0 15px rgba(220, 53, 69, 0.3);
    }

    /* Table styles */
    table.table-dark {
      color: var(--text-light);
      background-color: var(--dark-gray);
      border-radius: 10px;
      overflow: hidden;
    }

    table.table-dark thead th {
      border-bottom: 2px solid var(--red);
      color: var(--red);
    }

    table.table-dark tbody tr:hover {
      background-color: #2a2a2a;
      cursor: pointer;
      color: var(--red);
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
      #sidebar {
        position: fixed;
        z-index: 1040;
        left: -250px;
      }
      #sidebar.active {
        left: 0;
      }
      #top-navbar {
        left: 0;
      }
      #main-content {
        margin-left: 0;
        padding: 1rem;
      }
    }
    .bg-purple {
  background-color: var(--purple, #6f42c1) !important;
  color: white !important;
}
.form-title {
    color: #f8f9fa;
    font-size: 1.25rem;
    margin-bottom: 1rem;
    font-weight: 600;
  }

  .repair-form {
    background: rgba(30, 30, 30, 0.9);
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 0 20px rgba(0,0,0,0.3);
  }

  .repair-form .form-label {
    color: #d1d1d1;
    margin-bottom: 0.5rem;
    font-weight: 500;
  }

  .repair-form .form-control,
  .repair-form .form-select {
    background: rgba(255, 255, 255, 0.05);
    color: #f8f9fa;
    border: 1px solid #6c757d;
    border-radius: 0.5rem;
    padding: 0.6rem 0.75rem;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  .repair-form .form-control:focus,
  .repair-form .form-select:focus {
    border-color: #66ffcc;
    box-shadow: 0 0 0 0.1rem rgba(102, 255, 204, 0.25);
    outline: none;
  }

  .repair-form .btn-success {
    background-color: #28a745;
    border: none;
    padding: 0.6rem 1.2rem;
    font-weight: 600;
    border-radius: 0.5rem;
    transition: background-color 0.3s ease;
  }

  .repair-form .btn-success:hover {
    background-color: #218838;
  }
/* Container */
.select2-container--default .select2-selection--single {
  background-color: #1e1e2f !important;
  border: 1px solid #444 !important;
  color: #fff !important;
  border-radius: 8px !important;
  padding: 6px 12px;
  height: 40px;
  display: flex;
  align-items: center;
  box-shadow: none;
  transition: border 0.2s ease-in-out;
}

/* Text inside the select box */
.select2-container--default .select2-selection--single .select2-selection__rendered {
  color: #ffffff !important;
  line-height: 26px;
  padding-left: 4px;
}

/* Arrow icon */
.select2-container--default .select2-selection--single .select2-selection__arrow {
  height: 100%;
  right: 10px;
}

/* Dropdown options list */
.select2-container--default .select2-results__options {
  background-color: #1e1e2f;
  color: #ffffff;
  border-radius: 6px;
  padding: 6px 0;
}

/* Each option */
.select2-container--default .select2-results__option {
  padding: 10px 14px;
  color: #ddd;
  transition: background 0.2s ease-in-out;
}

/* Hovered/selected option */
.select2-container--default .select2-results__option--highlighted {
  background-color: #343a40;
  color: #fff;
}

/* Focus effect */
.select2-container--default.select2-container--focus .select2-selection--single {
  border-color: #5c7cfa !important;
  box-shadow: 0 0 0 2px rgba(92, 124, 250, 0.3);
}

/* Placeholder styling */
.select2-container--default .select2-selection--single .select2-selection__placeholder {
  color: #888 !important;
}
.select2-dropdown {
  transition: 0.2s ease-in-out;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
  border: none;
}
.select2-container--default .select2-search--dropdown .select2-search__field {
  background-color: #1e1e2f;
  color: #fff;
  border: 1px solid #444;
  border-radius: 6px;
  padding: 6px 10px;
}

/* Placeholder color inside the search field */
.select2-container--default .select2-search--dropdown .select2-search__field::placeholder {
  color: #aaa;
}
</style>
</head>
<body>

<div class="d-flex" style="height: 100vh; overflow: hidden;">
  <?= view('admin/sidebar') ?>

  <div class="flex-grow-1 d-flex flex-column" style="overflow-y: auto; background-color: rgba(45, 45, 68, 0.81);">
    <div id="main-content">
      <div class="container pt-0 pb-0">
        <div class="card shadow rounded-4" style="background: var(--dark-gray); border: none;">
          <div class="card-header rounded-top-4" style="background-color: var(--red); color: var(--text-light);">
            <h4 class="mb-0">Install and Repair Tickets</h4>
          </div>
          <div class="card-body">

            <!-- Section Title -->
            <h5 class="mb-3" style="color: var(--text-light);">Install Requests</h5>

            <?php
// Helper function to get badge class and text color based on status
function getBadgeClass($status) {
    switch (strtolower($status)) {
        case 'open':
        case 'assigned':
            return ['badge bg-purple text-white fw-semibold', 'Purple']; // custom class bg-purple, or use inline style if no class
        case 'on-going':
            return ['badge bg-primary text-white fw-semibold', 'Primary'];
        case 're-schedule':
            return ['badge bg-warning text-dark fw-semibold', 'Warning'];
        case 'cancelled':
            return ['badge bg-danger text-white fw-semibold', 'Danger'];
        case 'installed':
        case 'resolved':
            return ['badge bg-success text-white fw-semibold', 'Success'];
        default:
            return ['badge bg-secondary text-white fw-semibold', 'Secondary'];
    }
};
?>

<!-- Install Requests Table -->
<div class="table-responsive mb-4" style="max-height: 300px; overflow-y: auto;">
  <table class="table table-dark table-hover text-center align-middle small">
    <thead style="color: #28a745; border-bottom: 2px solid #28a745;">
      <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Plan</th>
        <th>Status</th>
        <th>Reason</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($installRequests)): ?>
        <tr>
          <td colspan="6" class="text-center" style="color: var(--text-light);">No install requests found.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($installRequests as $install): ?>
          <?php list($badgeClass, $badgeName) = getBadgeClass($install['app_status'] ?? ''); ?>
          <tr style="background-color: #1e1e1e;">
            <td><?= esc($install['first_name'] . ' ' . $install['last_name']) ?></td>
            <td><?= esc(trim($install['house_number'] . ' ' . $install['apartment'] . ' ' . $install['barangay'] . ', ' . $install['city'])) ?></td>
            <td><?= esc($install['plan']) ?></td>
            <td><span class="<?= $badgeClass ?>"><?= esc($install['app_status'] ?? 'N/A') ?></span></td>
            <td>
              <?= !empty($install['app_reason']) ? '<small class="text-muted" style="color: white !important;">' . esc($install['app_reason']) . '</small>' : '-' ?>
            </td>
            <td>
              <?php if (strtolower($install['app_status']) === 're-schedule'): ?>
                <button class="btn btn-sm btn-primary fw-bold reschedule-btn" onclick="handleInstallReschedule(<?= esc($install['id']) ?>)">
                  Re-schedule
                </button>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Repair Requests Table -->
<h5 class="mb-3" style="color: var(--text-light);">Repair Requests</h5>
<div class="table-responsive mb-4" style="max-height: 300px; overflow-y: auto;">
  <table class="table table-dark table-hover text-center align-middle small">
    <thead style="color: #ffc107; border-bottom: 2px solid #ffc107;">
      <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Issue</th>
        <th>Status</th>
        <th>Reason</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($repairRequests)): ?>
        <tr>
          <td colspan="6" class="text-center" style="color: var(--text-light);">No repair requests found.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($repairRequests as $repair): ?>
          <?php list($badgeClass, $badgeName) = getBadgeClass($repair['status'] ?? ''); ?>
          <tr style="background-color: #1e1e1e;">
            <td><?= esc($repair['first_name'] . ' ' . $repair['last_name']) ?></td>
            <td><?= esc(trim($repair['address'] . ', ' . $repair['city'])) ?></td>
            <td><?= esc($repair['issue']) ?></td>
            <td><span class="<?= $badgeClass ?>"><?= esc($repair['status'] ?? 'N/A') ?></span></td>
            <td>
              <?= !empty($repair['reason']) ? '<small class="text-muted" style="color:white !important;">' . esc($repair['reason']) . '</small>' : '-' ?>
            </td>
            <td>
              <?php if (strtolower($repair['status']) === 're-schedule'): ?>
                <button class="btn btn-sm btn-primary fw-bold" onclick="handleReschedule(<?= esc($repair['id']) ?>)">
                  Re-schedule
                </button>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div><br>

<div class="accordion bg-dark border border-light rounded-2 shadow-lg" id="repairAccordion">
  <div class="accordion-item bg-dark text-light border-0">
    <h2 class="accordion-header" id="headingRepair">
      <button class="accordion-button bg-dark text-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRepair" aria-expanded="false" aria-controls="collapseRepair">
        Generate Repair Ticket
      </button>
    </h2>
    <div id="collapseRepair" class="accordion-collapse collapse" aria-labelledby="headingRepair" data-bs-parent="#repairAccordion">
      <div class="accordion-body px-4 pt-0 pb-4">
        <form id="repairForm" method="POST" action="/admin/submit-repair-ticket">
          <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"><br>

          <!-- Select subscriber -->
          <div class="mb-4">
            <label for="subscriber_id" class="form-label">Select Subscriber</label>
            <select class="form-select bg-dark text-light border-secondary" id="subscriber_id" name="subscriber_id" required onchange="fillSubscriberInfo()" style="width: 100%;">
              <option></option> <!-- Keep this empty for placeholder to work -->
              <?php foreach ($subscribers as $subscriber): ?>
                <option value="<?= $subscriber['id'] ?>"
                        data-account="<?= esc($subscriber['account_number']) ?>"
                        data-name="<?= esc($subscriber['first_name'] . ' ' . $subscriber['last_name']) ?>">
                  <?= esc($subscriber['account_number'] . ' - ' . $subscriber['first_name'] . ' ' . $subscriber['last_name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Account Info side-by-side -->
          <div class="row mb-4">
            <div class="col-md-6">
              <label for="account_number" class="form-label">Account Number</label>
              <input type="text" class="form-control bg-dark text-light border-secondary" id="account_number" name="account_number" readonly>
            </div>
            <div class="col-md-6">
              <label for="account_name" class="form-label">Account Name</label>
              <input type="text" class="form-control bg-dark text-light border-secondary" id="account_name" name="account_name" readonly>
            </div>
          </div>

          <!-- Repair Issue Dropdown -->
          <div class="mb-4">
            <label for="repair_issue" class="form-label">Repair Issue</label>
            <select class="form-select bg-dark text-light border-secondary" id="repair_issue" name="issue" required>
              <option value="">-- Select Issue --</option>
              <option value="SLOW BROWSED">SLOW BROWSED</option>
              <option value="NO INTERNET CONNECTION">NO INTERNET CONNECTION</option>
              <option value="MODEM ISSUE">MODEM ISSUE</option>
              <option value="FOC WIRE CUT">FOC WIRE CUT</option>
              <option value="POWER ADAPTOR ISSUE">POWER ADAPTOR ISSUE</option>
            </select>
          </div>

          <!-- Additional Repair Details -->
          <div class="mb-4">
            <label for="repair_details" class="form-label">Additional Repair Details</label>
            <textarea class="form-control bg-dark text-light border-secondary" id="repair_details" name="description" rows="3" placeholder="Optional notes or details..."></textarea>
          </div>

          <!-- Scheduled Date -->
          <div class="mb-4">
            <label for="scheduled_date" class="form-label">Schedule Date</label>
            <input type="date" class="form-control bg-dark text-light border-secondary" id="scheduled_date" name="scheduled_date" required>
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-success fw-bold px-4">Send Repair Ticket</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (session()->getFlashdata('success')): ?>
<script>
Swal.fire({
  icon: 'success',
  title: 'Success!',
  text: '<?= session()->getFlashdata('success') ?>',
  confirmButtonColor: '#3085d6'
});
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<script>
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: '<?= session()->getFlashdata('error') ?>',
  confirmButtonColor: '#d33'
});
</script>
<?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Common SweetAlert2 settings
    function showSwal(title, text, icon = 'info') {
        return Swal.fire({
            title,
            text,
            icon,
            background: '#1a1a1a',
            color: '#f8f9fa',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
        });
    }

    // Filter functions
    $('#statusFilterRepair').on('change', function () {
        const val = $(this).val();
        $('#repairTicketsTable tbody tr').each(function () {
            const status = $(this).data('status');
            $(this).toggle(!val || status === val);
        });
    });

    $('#statusFilterInstall').on('change', function () {
        const val = $(this).val();
        $('#installRequestsTable tbody tr').each(function () {
            const status = $(this).data('status');
            $(this).toggle(!val || status === val);
        });
    });

    const updateRepairScheduleBaseUrl = "<?= base_url('admin/update_repair_schedule') ?>";
    const updateInstallScheduleBaseUrl = "<?= base_url('admin/update_install_schedule') ?>";

    // Global reschedule function for repair
    function handleReschedule(ticketId) {
        Swal.fire({
            title: 'Select new schedule date for Repair',
            html: '<input type="date" id="newScheduleDate" class="swal2-input">',
            background: '#1a1a1a',
            color: '#f8f9fa',
            showCancelButton: true,
            confirmButtonText: 'Update Schedule',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            preConfirm: () => {
                const newDate = document.getElementById('newScheduleDate').value;
                if (!newDate) {
                    Swal.showValidationMessage('You need to select a date!');
                    return false;
                }
                return newDate;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`${updateRepairScheduleBaseUrl}/${ticketId}/${result.value}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Schedule updated!',
                                icon: 'success',
                                background: '#1a1a1a',
                                color: '#f8f9fa',
                                confirmButtonColor: '#dc3545'
                            }).then(() => location.reload());
                        } else {
                            showSwal('Error', data.message, 'error');
                        }
                    }).catch(err => {
                        console.error(err);
                        showSwal('Error', 'Something went wrong.', 'error');
                    });
            }
        });
    }

    // Reschedule for install
    function handleInstallReschedule(applicationId) {
        Swal.fire({
            title: 'Select new schedule date for Install',
            html: '<input type="date" id="newScheduleDate" class="swal2-input">',
            background: '#1a1a1a',
            color: '#f8f9fa',
            showCancelButton: true,
            confirmButtonText: 'Update Schedule',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            preConfirm: () => {
                const newDate = document.getElementById('newScheduleDate').value;
                if (!newDate) {
                    Swal.showValidationMessage('You need to select a date!');
                    return false;
                }
                return newDate;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`${updateInstallScheduleBaseUrl}/${applicationId}/${result.value}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Schedule updated!',
                                icon: 'success',
                                background: '#1a1a1a',
                                color: '#f8f9fa',
                                confirmButtonColor: '#dc3545'
                            }).then(() => location.reload());
                        } else {
                            showSwal('Error', data.message, 'error');
                        }
                    }).catch(err => {
                        console.error(err);
                        showSwal('Error', 'Something went wrong.', 'error');
                    });
            }
        });
    }

    // Subscriber info autofill
    function fillSubscriberInfo() {
        const select = document.getElementById('subscriber_id');
        const selected = select.options[select.selectedIndex];
        if (!selected || selected.value === '') {
            document.getElementById('account_number').value = '';
            document.getElementById('account_name').value = '';
            return;
        }
        document.getElementById('account_number').value = selected.getAttribute('data-account') || '';
        document.getElementById('account_name').value = selected.getAttribute('data-name') || '';
    }

    // Document ready
    document.addEventListener('DOMContentLoaded', function () {
        $('#subscriber_id').select2({
            placeholder: '🔍 Search or select a subscriber',
            allowClear: true,
            width: '100%'
        });

        $('#subscriber_id').on('select2:select select2:unselect', fillSubscriberInfo);

        $('#subscriber_id').on('select2:open', function () {
            setTimeout(() => {
                $('.select2-search__field').attr('placeholder', 'Type to search...');
            }, 0);
        });
    });
</script>  
</body>
</html>
