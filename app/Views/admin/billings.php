<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title>Billing Status</title>
        <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
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
    .billing-form {
  background: rgba(30, 30, 30, 0.9);
  padding: 2rem;
  border-radius: 1rem;
  box-shadow: 0 0 20px rgba(0,0,0,0.3);
}

.billing-form .form-label {
  color: #d1d1d1;
  margin-bottom: 0.5rem;
  font-weight: 500;
}

.billing-form .form-control,
.billing-form .form-select {
  background: rgba(255, 255, 255, 0.05);
  color: #f8f9fa;
  border: 1px solid #6c757d;
  border-radius: 0.5rem;
  padding: 0.6rem 0.75rem;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.billing-form .form-control:focus,
.billing-form .form-select:focus {
  border-color:rgb(255, 0, 0);
  box-shadow: 0 0 0 0.1rem rgba(102, 255, 204, 0.25);
  outline: none;
}

.billing-form .btn-danger {
  background-color: #dc3545;
  border: none;
  padding: 0.6rem 1.2rem;
  font-weight: 600;
  border-radius: 0.5rem;
  transition: background-color 0.3s ease;
}

.billing-form .btn-danger:hover {
  background-color: #b02a37;
}

.accordion-button::after {
  display: none !important; /* Remove Bootstrap’s default icon */
}

#chevron-icon i {
  color: #ffffff !important;
  transition: transform 0.3s ease;
}

/* Rotates the icon when expanded */
.accordion-button:not(.collapsed) #chevron-icon i {
  transform: rotate(180deg);
}
#subscriber_id option {
    background-color: #212529; /* Bootstrap dark background */
    color: #f8f9fa; /* Bootstrap light text */
}
    </style>
</head>
<body>
<div class="d-flex" style="height: 100vh; overflow: hidden;">
  <?= view('admin/sidebar') ?>

 <div class="flex-grow-1 d-flex flex-column" style="overflow-y: auto; background-color:rgba(45, 45, 68, 0.81);">
    <div id="main-content">
        <div class="container py-4">
            <div class="card shadow rounded-4" style="background: var(--dark-gray); border: none;">
                <div class="card-header rounded-top-4" style="background-color: var(--red); color: var(--text-light);">
                    <h4 class="mb-0">Set Billing Date and Billing Status</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <div class="accordion mb-4" id="billingDateAccordion" style="background-color: #121212; border: 1px solid rgb(255, 255, 255); border-radius: 6px;">
                        <div class="accordion-item" style="background-color: transparent; border: none;">
                            <h2 class="accordion-header" id="headingBillingDate">
                                <button
                                    class="accordion-button collapsed d-flex justify-content-between align-items-center"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseBillingDate"
                                    aria-expanded="false"
                                    aria-controls="collapseBillingDate"
                                    style="background-color: #1e1e1e; color:rgb(255, 255, 255); font-weight: 700; border-radius: 1rem;"
                                >
                                    <span>Set Billing Date</span>
                                    <span class="ms-auto transition" id="chevron-icon">
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                </button>
                            </h2>
                            <div
                                id="collapseBillingDate"
                                class="accordion-collapse collapse"
                                aria-labelledby="headingBillingDate"
                                data-bs-parent="#billingDateAccordion"
                                style="background-color: transparent;"
                            >
                                <div class="accordion-body p-0">

                                    <form id="billingForm" method="post" action="<?= base_url('admin/save-billing-date') ?>" class="billing-form">
                                        <?= csrf_field() ?>

                                        <!-- Row for Subscriber and Plan -->
                                        <div class="mb-3 row">
                                            <div class="col-md-8">
                                                <label for="subscriber_id" class="form-label">Select Subscriber</label>
                                                <select class="form-select bg-dark text-light" name="subscriber_id" id="subscriber_id" required>
                                                    <option value="">-- Select Subscriber --</option>
                                                    <?php foreach ($subscribers as $sub): ?>
                                                        <?php if (empty($sub['billing_day'])): ?>
                                                            <option value="<?= $sub['id'] ?>" data-plan="<?= htmlspecialchars($sub['plan']) ?>">
                                                                <?= htmlspecialchars($sub['first_name'] . ' ' . $sub['last_name']) ?>
                                                                (<?= $sub['account_number'] ?>)
                                                            </option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="plan" class="form-label">Plan</label>
                                                <input type="text" name="plan" id="plan" class="form-control" disabled>
                                            </div>
                                        </div>

                                        <!-- Row for Billing Day and Price to Pay -->
                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label for="billing_day" class="form-label">Billing Day (e.g., 8)</label>
                                                <input type="number" name="billing_day" class="form-control" min="1" max="31" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="price_to_pay" class="form-label">Price to Pay</label>
                                                <input type="text" name="price_to_pay" id="price_to_pay" class="form-control" readonly>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-danger">Set Billing Date</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FILTER DROPDOWN -->
                    <div class="mb-3 d-flex justify-content-end align-items-center gap-2">
                        <label for="statusFilter" class="form-label mb-0" style="color: white;">Filter by Status:</label>
                        <select id="statusFilter" class="form-select" style="max-width: 200px;">
                            <option value="all" selected>All</option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                        </select>
                    </div>

                    <!-- Billing Status Table -->
                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-hover text-center align-middle" id="billingTable">
                            <thead>
                                <tr>
                                    <th>Account #</th>
                                    <th>Subscriber</th>
                                    <th>Billing Day</th>
                                    <th>Price to Pay</th>
                                    <th>Status</th>
                                    <th>Paid Date</th>
                                    <th>Invoice #</th>
                                    <th>Created At</th>
                                    <th>Due Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($billing_records)): ?>
                                    <?php foreach ($billing_records as $bill): ?>
                                        <tr data-billing-day="<?= esc($bill['billing_day']) ?>" data-status="<?= esc($bill['status']) ?>">
                                            <td><?= esc($bill['account_number']) ?></td>
                                            <td><?= esc($bill['full_name']) ?></td>
                                            <td><?= esc($bill['billing_day']) ?></td>
                                            <td>₱<?= esc(number_format($bill['price_to_pay'], 2)) ?></td>
                                            <td>
                                                <?php if ($bill['status'] == 'unpaid'): ?>
                                                    <span class="badge bg-danger">Unpaid</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Paid</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if (!empty($bill['paid_date'])) {
                                                        echo date('F d, Y h:i A', strtotime($bill['paid_date']));
                                                    } else {
                                                        echo '—';
                                                    }
                                                ?>
                                            </td>
                                            <td><?= esc($bill['invoice_number'] ?? '—') ?></td>
                                            <td><?= date('F d, Y H:i A', strtotime($bill['created_at'])) ?></td>
                                            <td>
                                                <?= date('F d, Y', strtotime($bill['due_date'])) ?>
                                                <?php if ($bill['is_overdue']): ?>
                                                    <span class="badge bg-danger ms-1">Overdue</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($bill['status'] == 'unpaid'): ?>
                                                    <button class="btn btn-success mark-paid-btn" data-id="<?= $bill['id'] ?>">Mark as Paid</button>
                                                <?php else: ?>
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <a href="<?= base_url('admin/view-statement/' . $bill['invoice_number']) ?>" 
                                                           class="btn btn-outline-success btn-sm view-statement-btn" 
                                                           title="View Statement"
                                                           target="_blank">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                        <a href="<?= base_url('admin/download-invoice/' . $bill['invoice_number']) ?>" 
                                                           class="btn btn-outline-secondary btn-sm download-invoice-btn"
                                                           title="Download Invoice">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="9" class="text-center">No billing records found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('statusFilter');
        const table = document.getElementById('billingTable');
        const tbody = table.querySelector('tbody');

        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value; // 'all', 'paid', or 'unpaid'

            Array.from(tbody.rows).forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (selectedStatus === 'all' || rowStatus === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
    const billingForm = document.getElementById('billingForm');
    const subscriberSelect = document.getElementById('subscriber_id');

    billingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to set a billing date for this subscriber.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, set it!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    subscriberSelect.addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        var plan = selectedOption.getAttribute('data-plan') || '';
        console.log('Selected plan:', plan);
        document.getElementById('plan').value = plan;

        let price = '';
        switch (plan.trim()) {
            case '50 Mbps': price = 799; break;
            case '100 Mbps': price = 999; break;
            case '130 Mbps': price = 1299; break;
            case '150 Mbps': price = 1499; break;
            default: price = '';
        }
        console.log('Price to pay:', price);
        document.getElementById('price_to_pay').value = price;
    });
});

// mark as paid sccripts:
document.querySelectorAll('.mark-paid-btn').forEach(button => {
  button.addEventListener('click', function() {
    const billId = this.getAttribute('data-id');

    Swal.fire({
      title: 'Set Paid Date',
      html: `<input type="datetime-local" id="paidDate" class="swal2-input" placeholder="Select paid date/time">`,
      confirmButtonText: 'Mark as Paid',
      showCancelButton: true,
      preConfirm: () => {
        const paidDate = Swal.getPopup().querySelector('#paidDate').value;
        if (!paidDate) {
          Swal.showValidationMessage('Please select a paid date');
        }
        return paidDate;
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const paidDate = result.value;

        // Show loading SweetAlert while processing
        Swal.fire({
          title: 'Processing...',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        fetch('<?= base_url("admin/mark-paid") ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            id: billId,
            paid_date: paidDate,
            '<?= csrf_token() ?>': document.querySelector('meta[name="csrf-token"]').content
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Close loading and show success with print option
            Swal.fire({
              title: 'Marked as Paid!',
              text: `Do you want to print the Invoice: ${data.invoice_number}?`,
              icon: 'success',
              showCancelButton: true,
              confirmButtonText: 'Yes, Print it',
              cancelButtonText: 'No, Print Later'
            }).then((printResult) => {
              if (printResult.isConfirmed) {
                window.open(`<?= base_url('admin/view-statement/') ?>${data.invoice_number}`, '_blank');
              }
              location.reload();

              // Update the row UI as before
              const row = document.querySelector(`button.mark-paid-btn[data-id="${billId}"]`).closest('tr');

              row.querySelector('td:nth-child(5)').innerHTML = '<span class="badge bg-success">Paid</span>';
              row.querySelector('td:nth-child(6)').textContent = new Date(data.paid_date).toLocaleString('en-US', { dateStyle: 'medium', timeStyle: 'short' });
              row.querySelector('td:nth-child(7)').textContent = data.invoice_number || '—';

              row.querySelector('td:nth-child(9)').innerHTML = `
                <div class="d-flex gap-1">
                  <a href="<?= base_url('admin/view-statement/') ?>${data.invoice_number}" class="btn btn-outline-success btn-sm" title="View Statement" target="_blank">
                    <i class="fas fa-print"></i>
                  </a>
                  <a href="<?= base_url('admin/download-invoice/') ?>${data.invoice_number}" class="btn btn-outline-secondary btn-sm" title="Download Invoice">
                    <i class="fas fa-download"></i>
                  </a>
                </div>
              `;
            });
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        })
        .catch(() => {
          Swal.fire('Error', 'Something went wrong!', 'error');
        });
      }
    });
  });
});

document.querySelectorAll('.view-statement-btn').forEach(button => {
  button.addEventListener('click', function(e) {
    e.preventDefault();

    const url = this.getAttribute('href');

    Swal.fire({
      title: 'Processing Print-view...',
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });

    setTimeout(() => {
      Swal.close();
      window.open(url, '_blank');
    }, 1000); // Simulate loading delay (adjust if needed)
  });
});

document.querySelectorAll('.download-invoice-btn').forEach(button => {
  button.addEventListener('click', function(e) {
    e.preventDefault();

    const url = this.getAttribute('href');

    Swal.fire({
      title: 'Creating download file...',
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });

    setTimeout(() => {
      Swal.close();
      window.location.href = url;
    }, 1000); // Simulate loading delay (adjust as needed)
  });
});

$(document).ready(function() {
  function filterTable() {
    const billingDay = $('#billingDayFilter').val();
    const searchText = $('#searchInput').val().toLowerCase().trim();

    $('tbody tr').each(function() {
      const rowBillingDay = $(this).data('billing-day').toString();
      const rowAccount = $(this).find('td').eq(0).text().toLowerCase();
      const rowName = $(this).find('td').eq(1).text().toLowerCase();

      const matchBillingDay = !billingDay || rowBillingDay === billingDay;
      const matchSearch = !searchText || rowAccount.includes(searchText) || rowName.includes(searchText);

      if (matchBillingDay && matchSearch) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  }

  $('#billingDayFilter').on('change', filterTable);
  $('#searchInput').on('input', filterTable);
});

    </script>
</body>
</html>
