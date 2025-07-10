<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">

    <title>Subscribers List</title>
<head>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Custom Styles -->
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
      overflow: visible;
    }
.dropdown-menu {
  z-index: 1050 !important; /* Higher than pagination */
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
    /* Modal background black */
#editSubscriberModal .modal-content {
  background-color: #121212; /* very dark black */
  border-radius: 1rem;
  color: #fff;
}

.dropdown-menu {
  z-index: 1050 !important; /* Higher than pagination */
}
/* Modal header with red background */
#editSubscriberModal .modal-header {
  background-color: #b71c1c; /* dark red */
  color: #fff;
  border-bottom: none;
  border-top-left-radius: 1rem;
  border-top-right-radius: 1rem;
}

/* Modal footer with red background */
#editSubscriberModal .modal-footer {
  background-color: #b71c1c; /* dark red */
  border-top: none;
  border-bottom-left-radius: 1rem;
  border-bottom-right-radius: 1rem;
}

/* Form labels */
#editSubscriberModal label {
  color: #ff5252; /* bright red */
  font-weight: 600;
}

/* Input fields */
#editSubscriberModal .form-control {
  background-color: #1e1e1e;
  border: 1px solid #b71c1c;
  color: #fff;
}

#editSubscriberModal .form-control:focus {
  background-color: #1e1e1e;
  border-color: #ff5252;
  box-shadow: 0 0 8px #ff5252;
  color: #fff;
}

/* Close button */
#editSubscriberModal .btn-close {
  filter: invert(1); /* white close button */
}

/* Submit button */
#editSubscriberModal .btn-success {
  background-color: #b71c1c;
  border-color: #b71c1c;
  font-weight: 700;
}

#editSubscriberModal .btn-success:hover {
  background-color: #ff5252;
  border-color: #ff5252;
}
    </style>
</head>
<body>

<div class="d-flex" style="height: 100vh; overflow: hidden;">
  <?= view('admin/sidebar') ?>

  <div class="flex-grow-1 d-flex flex-column" style="overflow-y: auto; background-color:rgba(45, 45, 68, 0.81);">
    <div id="main-content">
      <div class="d-flex justify-content-end mb-3" style="padding-top: 20px; padding-right: 20px;">
        <div class="input-group rounded shadow-sm" style="max-width: 300px;">
          <span class="input-group-text bg-light border-0" id="search-addon">
            <i class="bi bi-search text-secondary"></i>
          </span>
          <input
            type="text"
            class="form-control border-0 bg-light"
            placeholder="Search subscribers..."
            aria-label="Search"
            aria-describedby="search-addon"
            id="subscriber-search"
          />
        </div>
      </div>

      <?php if (empty($subscribers)): ?>
        <div class="alert alert-warning text-center">No subscribers found.</div>
      <?php else: ?>
        <div class="container-fluid">
          <div class="card shadow-sm rounded-4 bg-dark text-light">
            <div class="card-header bg-danger text-white rounded-top-4 d-flex justify-content-between align-items-center">
              <h4 class="mb-0">Subscribers</h4>
                <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#addSubscriberModal">
                <i class="bi bi-plus-circle"></i> Add Subscriber
                </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-dark table-hover text-center align-middle small">
                  <thead>
                    <tr>
                      <th>Account No.</th>
                      <th>Name</th>
                      <th>Contact</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Location</th>
                      <th>Plan</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <?php
                    usort($subscribers, function ($a, $b) {
                        // Prioritize null/empty account numbers
                        if (empty($a['account_number']) && !empty($b['account_number'])) {
                            return -1; // $a before $b
                        }
                        if (!empty($a['account_number']) && empty($b['account_number'])) {
                            return 1; // $b before $a
                        }
                        // Otherwise, sort by created_at (newest first)
                        return strcmp($b['created_at'], $a['created_at']);
                    });
                    ?>
                  <tbody id="subscriber-table-body">
                    <?php foreach ($subscribers as $subscriber): ?>
                      <tr class="subscriber-row">
                        <td>
                        <?php if (empty($subscriber['account_number'])): ?>
  <div class="d-flex justify-content-center gap-2">
    <input
      type="text"
      class="account-input form-control form-control-sm bg-dark text-light border-secondary"
      placeholder="Assign #"
      data-id="<?= $subscriber['id'] ?>"
      data-city="<?= esc($adminArea) ?>"
    >
    <button
      class="btn btn-sm btn-outline-primary predict-account-btn"
      data-city="<?= esc($adminArea) ?>"
      title="Predict Account Number"
    >
      <i class="bi bi-lightning-charge"></i>
    </button>
    <button
      class="btn btn-sm btn-outline-success save-account-btn"
      data-id="<?= $subscriber['id'] ?>"
      title="Save Account Number"
    >
      <i class="bi bi-save"></i>
    </button>
  </div>
<?php else: ?>
  <span class="fw-semibold"><?= esc($subscriber['account_number']) ?></span>
<?php endif; ?>
                        </td>
                        <td>
                          <span class="fw-semibold">
                            <?= esc($subscriber['first_name'] . ' ' . $subscriber['middle_name'] . ' ' . $subscriber['last_name']) ?>
                          </span>
                        </td>
                        <td><?= esc($subscriber['contact_number1'] . ' / ' . $subscriber['contact_number2']) ?></td>
                        <td><?= esc($subscriber['email']) ?></td>
                        <td>
                          <?php
                            $status = $subscriber['status'];
                            $statusClass = match($status) {
                              'Active' => 'success',
                              'Disconnected' => 'danger',
                              'For Pull Out' => 'secondary',
                              'Pulled Out' => 'warning',
                              default => 'primary',
                            };
                          ?>
                          <span class="badge bg-<?= $statusClass ?>"><?= esc($status) ?></span>
                        </td>
                        <td><?= esc($subscriber['address'] . ', ' . $subscriber['city']) ?></td>
                        <td><?= esc($subscriber['plan']) ?></td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn btn-light btn-sm d-flex align-items-center" type="button" id="controlsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                              <span>Controls</span>
                              <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="controlsDropdown">
                              <li><a class="dropdown-item text-success status-action" href="#" data-status="Active" data-id="<?= $subscriber['id'] ?>">Active</a></li>
                              <li><a class="dropdown-item text-danger status-action" href="#" data-status="Disconnected" data-id="<?= $subscriber['id'] ?>">Disconnected</a></li>
                              <li><a class="dropdown-item text-warning status-action" href="#" data-status="For Pull Out" data-id="<?= $subscriber['id'] ?>">For Pull Out</a></li>
                              <li><a class="dropdown-item text-muted status-action" href="#" data-status="Pulled Out" data-id="<?= $subscriber['id'] ?>">Pulled Out</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item edit-btn" href="#" data-id="<?= $subscriber['id'] ?>">Edit</a></li>
                            </ul>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <div class="d-flex justify-content-end mt-3">
                  <nav>
                    <ul class="pagination pagination-sm mb-0" id="pagination-controls"></ul>
                  </nav>
                </div>
              </div> <!-- .table-responsive -->
            </div> <!-- .card-body -->
          </div> <!-- .card -->
        </div> <!-- .container-fluid -->
      <?php endif; ?>
    </div> <!-- #main-content -->
  </div> <!-- .flex-grow-1 -->
</div> <!-- .d-flex -->


<!-- Edit Modal -->
<div class="modal fade" id="editSubscriberModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editSubscriberForm">
        <?= csrf_field() ?>
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Edit Subscriber</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="subscriber_id" id="edit_subscriber_id">
                <div class="mb-3">
                    <label for="edit_first_name" class="form-label fw-semibold">First Name</label>
                    <input type="text" class="form-control form-control-lg" name="first_name" id="edit_first_name" required>
                </div>
                <div class="mb-3">
                    <label for="edit_last_name" class="form-label fw-semibold">Last Name</label>
                    <input type="text" class="form-control form-control-lg" name="last_name" id="edit_last_name" required>
                </div>
                <div class="mb-3">
                    <label for="edit_contact" class="form-label fw-semibold">Contact Number</label>
                    <input type="text" class="form-control form-control-lg" name="contact_number1" id="edit_contact" required>
                </div>
                <div class="mb-3">
                    <label for="edit_plan" class="form-label fw-semibold">Plan</label>
                    <input type="text" class="form-control form-control-lg" name="plan" id="edit_plan" required>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-success btn-lg w-100 fw-semibold">Save Changes</button>
            </div>
        </div>
    </form>
  </div>
</div>

<!-- Add Subscriber Modal -->
<div class="modal fade" id="addSubscriberModal" tabindex="-1" aria-labelledby="addSubscriberLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark text-light" style="border-radius: 0.5rem; border: 2px solid #d32f2f;">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="addSubscriberLabel" style="color:#d32f2f;">Add Subscriber</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addSubscriberForm" method="post" action="<?= base_url('admin/add-subscriber') ?>" class="px-4 pb-4">
        <?= csrf_field() ?>
        <div class="modal-body">

          <!-- Personal Information Group -->
          <h6 class="text-danger mb-3">Personal Information</h6>
          <div class="row g-3 mb-4">
            <div class="col-md-4">
              <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control form-control-sm" id="first_name" name="first_name" required>
            </div>
            <div class="col-md-4">
              <label for="middle_name" class="form-label">Middle Name</label>
              <input type="text" class="form-control form-control-sm" id="middle_name" name="middle_name">
            </div>
            <div class="col-md-4">
              <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control form-control-sm" id="last_name" name="last_name" required>
            </div>
          </div>

          <!-- Contact Information Group -->
          <h6 class="text-danger mb-3">Contact Information</h6>
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label for="contact_number1" class="form-label">Contact Number 1 <span class="text-danger">*</span></label>
              <input type="tel" class="form-control form-control-sm" id="contact_number1" name="contact_number1" required>
            </div>
            <div class="col-md-6">
              <label for="contact_number2" class="form-label">Contact Number 2</label>
              <input type="tel" class="form-control form-control-sm" id="contact_number2" name="contact_number2">
            </div>
            <div class="col-md-12">
              <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control form-control-sm" id="email" name="email" required>
            </div>
          </div>

          <!-- Address Group -->
          <h6 class="text-danger mb-3">Address</h6>
          <div class="row g-3 mb-4">
            <div class="col-12">
              <label for="address" class="form-label">Street Address <span class="text-danger">*</span></label>
              <input type="text" class="form-control form-control-sm" id="address" name="address" required>
            </div>
            <div class="col-md-6">
              <label for="city" class="form-label">City / Area <span class="text-danger">*</span></label>
              <input type="text" class="form-control form-control-sm bg-secondary text-light" id="city" name="city" readonly>
            </div>
          </div>

          <!-- Plan & Account Details Group -->
          <h6 class="text-danger mb-3">Plan & Account Details</h6>
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label for="plan" class="form-label">Plan <span class="text-danger">*</span></label>
              <select class="form-select form-select-sm" id="plan" name="plan" required>
                <option value="" selected disabled>Select Plan</option>
                <option value="50 Mbps">50 Mbps</option>
                <option value="100 Mbps">100 Mbps</option>
                <option value="130 Mbps">130 Mbps</option>
                <option value="150 Mbps">150 Mbps</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="account_number" class="form-label">Account Number</label>
              <input type="text" class="form-control form-control-sm" id="account_number" name="account_number">
            </div>
            <div class="col-md-6">
              <label for="price_to_pay" class="form-label">Price to Pay <span class="text-danger">*</span></label>
              <input type="number" min="0" step="0.01" class="form-control form-control-sm" id="price_to_pay" name="price_to_pay" required readonly>

            </div>
            <div class="col-md-6">
              <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
              <select class="form-select form-select-sm" id="status" name="status" required>
                <option value="" selected disabled>Select Status</option>
                <option value="Connected">Old Subscriber</option>
                <option value="New Subscriber">New Subscriber</option>
              </select>
            </div>
          </div>

        </div>
        <div class="modal-footer border-top-0 pt-0">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger btn-sm">Add Subscriber</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  const csrfName = '<?= csrf_token() ?>';
  const csrfHash = '<?= csrf_hash() ?>';

  // Dark red Swal mixin
  const DarkSwal = Swal.mixin({
    background: '#1e1e1e',
    color: '#ff4d4d',
    customClass: 'dark-red-theme'
  });

  $(".edit-btn").click(function () {
    const subscriberId = $(this).data("id");
    $.get("<?= base_url('admin/getSubscriber') ?>/" + subscriberId, function(data) {
      if (data) {
        $('#edit_subscriber_id').val(data.id);
        $('#edit_first_name').val(data.first_name);
        $('#edit_last_name').val(data.last_name);
        $('#edit_contact').val(data.contact_number1);
        $('#edit_plan').val(data.plan);
        $('#editSubscriberModal').modal('show');
      } else {
        DarkSwal.fire('Error', 'Subscriber data not found.', 'error');
      }
    });
  });

  $("#editSubscriberForm").submit(function(e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.post("<?= base_url('admin/updateSubscriber') ?>", formData)
      .done(() => {
        DarkSwal.fire('Success', 'Subscriber updated successfully.', 'success').then(reloadPage);
      })
      .fail(() => {
        DarkSwal.fire('Error', 'Failed to update subscriber.', 'error');
      });
  });

  $(".save-account-btn").click(function () {
    const subscriberId = $(this).data("id");
    const input = $(this).siblings('input.account-input');
    const accountNumber = input.val().trim();

    if (!accountNumber) {
      DarkSwal.fire('Warning', 'Please enter an account number.', 'warning');
      return;
    }

    $.post("<?= base_url('admin/saveAccountNumber') ?>", {
      subscriber_id: subscriberId,
      account_number: accountNumber,
      [csrfName]: csrfHash
    }).done(() => {
      DarkSwal.fire('Success', 'Account number saved.', 'success').then(reloadPage);
    }).fail(() => {
      DarkSwal.fire('Error', 'Failed to save account number.', 'error');
    });
  });

  document.getElementById('subscriber-search').addEventListener('input', function () {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');
    rows.forEach(row => {
      const text = row.innerText.toLowerCase();
      row.style.display = text.includes(filter) ? '' : 'none';
    });
  });

  const rows = document.querySelectorAll('.subscriber-row');
  const rowsPerPage = 10;
  const paginationControls = document.getElementById('pagination-controls');
  let currentPage = 1;

  function displayRows(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    rows.forEach((row, index) => {
      row.style.display = (index >= start && index < end) ? '' : 'none';
    });
  }

  function updatePagination() {
    paginationControls.innerHTML = '';
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    for (let i = 1; i <= totalPages; i++) {
      const li = document.createElement('li');
      li.className = 'page-item' + (i === currentPage ? ' active' : '');

      const a = document.createElement('a');
      a.className = 'page-link';
      a.href = '#';
      a.textContent = i;
      a.addEventListener('click', function (e) {
        e.preventDefault();
        currentPage = i;
        displayRows(currentPage);
        updatePagination();
      });

      li.appendChild(a);
      paginationControls.appendChild(li);
    }
  }

  function reloadPage() {
    location.reload();
  }

  displayRows(currentPage);
  updatePagination();

  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".status-action").forEach(function (element) {
      element.addEventListener("click", function (e) {
        e.preventDefault();

        const id = this.dataset.id;
        const status = this.dataset.status;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("<?= site_url('admin/update-subscriber-status') ?>", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: new URLSearchParams({
            id: id,
            status: status,
            csrf_test_name: csrfToken
          })
        })
        .then(response => response.text())
        .then(data => {
          console.log("Response:", data);
          DarkSwal.fire("Success", data, "success").then(() => location.reload());
        })
        .catch(error => {
          console.error("Error:", error);
          DarkSwal.fire("Error", "Something went wrong.", "error");
        });
      });
    });
  });

  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', async function(e) {
      e.preventDefault();
      const subscriberId = this.getAttribute('data-id');

      try {
        const res = await fetch(`/admin/get-subscriber/${subscriberId}`, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();

        if (data.status === 'success') {
          document.getElementById('edit_subscriber_id').value = data.subscriber.id;
          document.getElementById('edit_first_name').value = data.subscriber.first_name;
          document.getElementById('edit_last_name').value = data.subscriber.last_name;
          document.getElementById('edit_contact').value = data.subscriber.contact_number1;
          document.getElementById('edit_plan').value = data.subscriber.plan;

          const editModal = new bootstrap.Modal(document.getElementById('editSubscriberModal'));
          editModal.show();
        } else {
          DarkSwal.fire('Error', data.message, 'error');
        }
      } catch (err) {
        DarkSwal.fire('Error', 'Failed to load subscriber data.', 'error');
      }
    });
  });

  document.getElementById('addSubscriberForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let form = e.target;
    let formData = new FormData(form);
    formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

    fetch('<?= base_url("admin/add-subscriber") ?>', {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        DarkSwal.fire({
          icon: 'success',
          title: 'Success',
          text: data.message,
          timer: 2000,
          showConfirmButton: false
        });
        form.reset();
        var modal = bootstrap.Modal.getInstance(document.getElementById('addSubscriberModal'));
        modal.hide();
        location.reload();
      } else {
        DarkSwal.fire('Error', data.message, 'error');
      }
    })
    .catch(() => {
      DarkSwal.fire('Error', 'Failed to add subscriber. Try again later.', 'error');
    });
  });

  document.addEventListener('DOMContentLoaded', () => {
    const cityInput = document.getElementById('city');
    cityInput.value = "<?= session()->get('area') ?>";

    const planSelect = document.getElementById('plan');
    const priceInput = document.getElementById('price_to_pay');

    const planPrices = {
      '50 Mbps': 799,
      '100 Mbps': 999,
      '130 Mbps': 1299,
      '150 Mbps': 1499
    };

    planSelect.addEventListener('change', () => {
      const selectedPlan = planSelect.value;
      priceInput.value = planPrices[selectedPlan] || '';
    });

    const addSubscriberModal = document.getElementById('addSubscriberModal');
    addSubscriberModal.addEventListener('hidden.bs.modal', () => {
      document.getElementById('addSubscriberForm').reset();
      cityInput.value = "<?= session()->get('area') ?>";
      priceInput.value = '';
    });
  });
  $(document).on('click', '.predict-account-btn', function () {
  const row = $(this).closest('tr');
  const input = row.find('.account-input');
  const city = $(this).data('city');

  fetch(`<?= base_url('admin/predictAccountNumber/') ?>${encodeURIComponent(city)}`)
    .then(res => res.json())
    .then(data => {
      input.val(data.next_account_number);
    })
    .catch(() => {
      Swal.fire('Error', 'Failed to predict account number.', 'error');
    });
});
</script>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
