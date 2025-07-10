<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Finance Management</title>
      <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* Scrollbar */
    ::-webkit-scrollbar { width: 10px; height: 10px; }
    ::-webkit-scrollbar-track { background: #1e1e1e; border-radius: 10px; }
    ::-webkit-scrollbar-thumb {
      background-color: #4caf50;
      border-radius: 10px;
      border: 2px solid #1e1e1e;
    }
    ::-webkit-scrollbar-thumb:hover { background-color: #66bb6a; }

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

    #main-content {
      margin-top: 60px;
      margin-left: 250px;
      padding: 2rem;
      transition: margin-left 0.3s;
      min-height: calc(100vh - 60px);
    }

    /* Dark Tables */
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
    .table-title {
      font-weight: 600;
      color: var(--text-light);
      margin-bottom: 0.5rem;
    }

    @media (max-width: 992px) {
      #main-content {
        margin-left: 0;
        padding: 1rem;
      }
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
.dark-card {
    background-color: #1e1e2f;
    color: #e0e0e0;
    border: 1px solid #333;
    border-radius: 12px;
    box-shadow: 0 0 8px rgba(0,0,0,0.4);
}
.dark-card1 {
    background-color: #230000;
    color: #e0e0e0;
    border: 1px solid #333;
    border-radius: 12px;
    box-shadow: 0 0 8px rgba(0,0,0,0.4);
}

.dark-card-subsection {
    background-color: #2a2a3d;
    padding: 20px;
    border-radius: 12px;
}
  </style>
</head>
<body>
  <div class="d-flex" style="height: 100vh; overflow: hidden;">
    <?= view('admin/sidebar') ?>

    <div class="flex-grow-1 d-flex flex-column" style="overflow-y: auto; background-color: rgba(45, 45, 68, 0.81);">
      <div id="main-content">
        <div class="container py-4">
        <div class="card shadow rounded-4" style="background: var(--dark-gray); border: none;">
          <div class="card-header rounded-top-4" style="background-color: var(--red); color: var(--text-light);">
            <h4 class="mb-0">Finance Records</h4>
          </div>
            <div class="card-body">

              <!-- Accordion Form -->
              <div class="accordion" id="accordionExample" style="margin: auto; padding: 1rem; background-color: transparent; border: none;">
              <div class="accordion-item" style="background-color: transparent; border: 1px solid white">
                  <h2 class="accordion-header" id="headingCreateRecord">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseCreateRecord" aria-expanded="false" aria-controls="collapseCreateRecord"
                      style="background-color: #1e1e1e; color:rgb(255, 255, 255); font-weight: 700; border-radius: 1rem;">
                      <span>Create Finance Record</span>
                      <span class="ms-auto transition" id="chevron-icon">
                      <i class="fas fa-chevron-down"></i>
                    </button>
                  </h2>
                  <div id="collapseCreateRecord" class="accordion-collapse collapse" aria-labelledby="headingCreateRecord"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <form method="get" id="typeSelectorForm" class="mb-3 mt-3">
                        <div class="mb-3">
                          <label for="type" class="form-label text-light">Record Type</label>
                          <select name="type" id="type" class="form-select bg-dark text-light"
                            onchange="document.getElementById('typeSelectorForm').submit();">
                            <option value="revenue" <?= $type === 'revenue' ? 'selected' : '' ?>>Revenue</option>
                            <option value="expenses" <?= $type === 'expenses' ? 'selected' : '' ?>>Expenses</option>
                          </select>
                        </div>
                      </form>

                      <form method="post" action="<?= base_url('admin/finance/store') ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="type" value="<?= esc($type) ?>">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category" class="form-label text-light">Category</label>
                                <input type="text" class="form-control bg-dark text-light border-secondary" name="category" required>
                            </div>
                            <div class="col-md-6">
                                <label for="quantity" class="form-label text-light">Quantity</label>
                                <input type="number" class="form-control bg-dark text-light border-secondary" name="quantity">
                            </div>
                        </div>


                        <div class="mb-3">
                          <label for="amount" class="form-label text-light">Amount</label>
                          <input type="number" class="form-control bg-dark text-light border-secondary" name="amount" step="0.01" required>
                        </div>

                        <div class="mb-3">
                          <label for="record_date" class="form-label text-light">Date</label>
                          <input type="date" class="form-control bg-dark text-light border-secondary" name="record_date" required>
                        </div>

                        <div class="mb-3">
                          <label for="description" class="form-label text-light">Description</label>
                          <textarea name="description" class="form-control bg-dark text-light border-secondary" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-danger">Save</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card mt-5 dark-card1 pb-4" style="margin-top: 0px;">

              <div class="container mt-4 text-light">
    <!-- Month Filter -->
     
    <form method="get" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <select name="month" class="form-select bg-dark text-light border-secondary" onchange="this.form.submit()">
                    <option value="">-- Filter by Month --</option>
                    <?php foreach ($months as $m): ?>
                        <option value="<?= $m ?>" <?= ($selectedMonth == $m) ? 'selected' : '' ?>><?= $m ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </form>

    <div class="row g-4">
        <!-- Revenues Column -->
        <div class="col-md-6">
            <h4 class="mb-3 text-success">Revenues</h4>
            <?php
                $totalRevenue = 0;
                $hasMonthly = false;
                $hasInstallation = false;
                $hasOthers = false;

                $monthlyRevenues = [];
                $installationRevenues = [];
                $otherRevenues = [];

                foreach ($revenue as $rec) {
                    $totalRevenue += $rec['amount'];

                    if (stripos($rec['category'], 'Monthly') !== false) {
                        $hasMonthly = true;
                        $monthlyRevenues[] = $rec;
                    } elseif (stripos($rec['category'], 'Installation') !== false) {
                        $hasInstallation = true;
                        $installationRevenues[] = $rec;
                    } else {
                        $hasOthers = true;
                        $otherRevenues[] = $rec;
                    }
                }
                ?>

            <!-- Monthly Revenue Card -->
 <div class="card bg-dark border-secondary shadow-sm mb-4">
    <div class="card-header bg-secondary bg-opacity-10 text-light fw-semibold">
        Revenue Summary
    </div>
    <div class="card-body p-3" style="max-height: 600px; overflow-y: auto;">
        
       <!-- Monthly Payments Section -->
<h5 class="text-success mb-3">Monthly Payments</h5>
<?php if ($hasMonthly): ?>
    <?php foreach ($monthlyRevenues as $rec): ?>
        <div class="mb-3 p-3 border-start border-3 border-success bg-black bg-opacity-25 rounded">
            <h6 class="mb-1 text-white"><?= esc($rec['category']) ?></h6>
            <small class="text-light text-opacity-75 d-block"><?= esc($rec['description']) ?></small>
            <div class="mt-2">
                <div class="fw-bold text-success">₱<?= number_format($rec['amount'], 2) ?></div>
                <div class="text-light text-opacity-50 small"><?= date('M d, Y', strtotime($rec['record_date'])) ?> · <?= esc($rec['created_by']) ?></div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-muted">No monthly payments found.</p>
<?php endif; ?>

<hr class="border-secondary my-4">

<!-- Installation Fees Section -->
<h5 class="text-warning mb-3">Installation Fees</h5>
<?php if ($hasInstallation): ?>
    <?php foreach ($installationRevenues as $rec): ?>
        <div class="mb-3 p-3 border-start border-3 border-warning bg-black bg-opacity-25 rounded">
            <h6 class="mb-1 text-white"><?= esc($rec['category']) ?></h6>
            <small class="text-light text-opacity-75 d-block"><?= esc($rec['description']) ?></small>
            <div class="mt-2">
                <div class="fw-bold text-warning">₱<?= number_format($rec['amount'], 2) ?></div>
                <div class="text-light text-opacity-50 small"><?= date('M d, Y', strtotime($rec['record_date'])) ?> · <?= esc($rec['created_by']) ?></div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-muted">No installation fees found.</p>
<?php endif; ?>

<hr class="border-secondary my-4">

<!-- Other Revenues Section -->
<h5 class="text-info mb-3">Other Revenues</h5>
<?php if ($hasOthers): ?>
    <?php foreach ($otherRevenues as $rec): ?>
        <div class="mb-3 p-3 border-start border-3 border-info bg-black bg-opacity-25 rounded">
            <h6 class="mb-1 text-white"><?= esc($rec['category'].' '. esc($rec['quantity'])) ?></h6>
            <small class="text-light text-opacity-75 d-block"><?= esc($rec['description']) ?></small>
            <div class="mt-2">
                <div class="fw-bold text-info">₱<?= number_format($rec['amount'], 2) ?></div>
                <div class="text-light text-opacity-50 small"><?= date('M d, Y', strtotime($rec['record_date'])) ?> · <?= esc($rec['created_by']) ?></div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-muted">No other revenue records found.</p>
<?php endif; ?>
</div>
</div>

        </div>
        <div class="col-md-6">
        <h4 class="mb-3 text-danger">Expenses</h4>
        <!-- Expenses Column -->
        <div class="card bg-dark border-danger shadow-sm">
    <div class="card-header bg-danger bg-opacity-10 text-light fw-semibold">
        All Expenses
    </div>
    <?php
            $totalExpense = 0;
            $hasExpense = false;
        ?>
    <div class="card-body p-3" style="max-height: 600px; overflow-y: auto;">
        <?php foreach ($expenses as $rec): ?>
            <?php 
                    $totalExpense += $rec['amount']; 
                    $hasExpense = true;
                ?>
            <div class="mb-3 p-3 border-start border-3 border-danger bg-black bg-opacity-25 rounded">
                <h6 class="mb-1 text-white"><?= esc($rec['category'] .' '. esc($rec['quantity']))?></h6>
                <small class="text-light text-opacity-75 d-block"><?= esc($rec['description']) ?></small>
                <div class="mt-2">
                    <div class="fw-bold text-danger">₱<?= number_format($rec['amount'], 2) ?></div>
                    <div class="text-light text-opacity-50 small"><?= date('M d, Y', strtotime($rec['record_date'])) ?> · <?= esc($rec['created_by']) ?></div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (!$hasExpense): ?>
            <p class="text-muted">No expense records found.</p>
        <?php endif; ?>
    </div>
</div>
        </div>
    </div>
</div>
        </div>


<div class="card mt-5 dark-card">
    <div class="card-body">
        <h2 class="mb-4 text-light">Monthly Financial Report - <?= esc($selectedMonth) ?></h2>

        <div class="d-flex justify-content-end mb-4 no-print">
            <a href="<?= base_url('admin/finance/export-report/' . $selectedMonth) ?>" class="btn btn-success">
                <i class="bi bi-download me-1"></i> Download Report
            </a>
        </div>

        <!-- Two Columns Layout -->
        <div class="row g-4">
            <!-- Left Column: Monthly & Other Revenues -->
            <div class="col-md-6">
                <!-- Monthly Revenue Table -->
                <div class="dark-card-subsection mb-4">
    <h5 class="text-light mb-3">Revenue Summary</h5>
    <div class="table-responsive" style="max-height: 520px; overflow-y: auto;">
        <table class="table table-bordered table-dark table-hover">
            <thead class="table-light text-dark sticky-top" style="top: 0; background: #f8f9fa;">
                <tr>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th class="text-end">Amount (₱)</th>
                </tr>
            </thead>
            <tbody>
                <!-- Monthly Revenue Header -->
                <tr class="table-success fw-bold text-dark">
                    <td colspan="5" class="bg-success bg-opacity-75">Monthly Revenue</td>
                </tr>
                <?php
                $totalMonthlyRevenue = 0;
                foreach ($revenue as $item):
                    if (stripos($item['category'], 'monthly') !== false):
                        $amount = floatval($item['amount']);
                        $totalMonthlyRevenue += $amount;
                ?>
                <tr>
                    <td><?= esc($item['category']) ?></td>
                    <td><?= esc($item['quantity'])?></td>
                    <td><?= esc($item['description']) ?></td>
                    <td><?= date('M d, Y', strtotime($item['created_at'])) ?></td>
                    <td class="text-end"><?= number_format($amount, 2) ?></td>
                </tr>
                <?php
                    endif;
                endforeach;
                ?>
                <tr class="table-success fw-bold text-dark">
                    <td colspan="4" class="text-end">Total Monthly Revenue</td>
                    <td class="text-end text-success">₱<?= number_format($totalMonthlyRevenue, 2) ?></td>
                </tr>

                <!-- Installation Fees Header -->
                <tr class="table-warning fw-bold text-dark">
                    <td colspan="5" class="bg-warning bg-opacity-75">Installation Fees</td>
                </tr>
                <?php
                $totalInstallationRevenue = 0;
                foreach ($revenue as $item):
                    if (stripos($item['category'], 'installation') !== false):
                        $amount = floatval($item['amount']);
                        $totalInstallationRevenue += $amount;
                ?>
                <tr>
                    <td><?= esc($item['category']) ?></td>
                    <td><?= esc($item['quantity'])?></td>
                    <td><?= esc($item['description']) ?></td>
                    <td><?= date('M d, Y', strtotime($item['created_at'])) ?></td>
                    <td class="text-end"><?= number_format($amount, 2) ?></td>
                </tr>
                <?php
                    endif;
                endforeach;
                ?>
                <tr class="table-warning fw-bold text-dark">
                    <td colspan="4" class="text-end">Total Installation Fees</td>
                    <td class="text-end text-warning">₱<?= number_format($totalInstallationRevenue, 2) ?></td>
                </tr>

                <!-- Other Revenue Header -->
                <tr class="table-info fw-bold text-dark">
                    <td colspan="5" class="bg-info bg-opacity-75">Other Revenue</td>
                </tr>
                <?php
                $totalOtherRevenue = 0;
                foreach ($revenue as $item):
                    if (stripos($item['category'], 'monthly') === false && stripos($item['category'], 'installation') === false):
                        $amount = floatval($item['amount']);
                        $totalOtherRevenue += $amount;
                ?>
                <tr>
                    <td><?= esc($item['category']) ?></td>
                    <td><?= esc($item['quantity'])?></td>
                    <td><?= esc($item['description']) ?></td>
                    <td><?= date('M d, Y', strtotime($item['created_at'])) ?></td>
                    <td class="text-end"><?= number_format($amount, 2) ?></td>
                </tr>
                <?php
                    endif;
                endforeach;
                ?>
                <tr class="table-info fw-bold text-dark">
                    <td colspan="4" class="text-end">Total Other Revenue</td>
                    <td class="text-end text-info">₱<?= number_format($totalOtherRevenue, 2) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
            </div>

            <!-- Right Column: Expenses -->
            <div class="col-md-6">
                <div class="dark-card-subsection">
                    <h5 class="text-light mb-3">Expenses</h5>
                    <div class="table-responsive" style="max-height: 520px; overflow-y: auto;">
                        <table class="table table-bordered table-dark table-hover">
                            <thead class="table-danger text-dark">
                                <tr>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th class="text-end">Amount (₱)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $totalExpenses = 0;
                                foreach ($expenses as $item):
                                    $amount = floatval($item['amount']);
                                    $totalExpenses += $amount;
                                ?>
                                <tr>
                                    <td><?= esc($item['category']) ?></td>
                                    <td><?= esc($item['quantity'])?></td>
                                    <td><?= esc($item['description']) ?></td>
                                    <td><?= date('M d, Y', strtotime($item['created_at'])) ?></td>
                                    <td class="text-end"><?= number_format($amount, 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-danger fw-bold text-dark">
                                    <td colspan="4" class="text-end">Total Expenses</td>
                                    <td class="text-end text-danger">₱<?= number_format($totalExpenses, 2) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


        <!-- Net Income Summary -->
        <?php 
        $netIncome = $totalRevenue - $totalExpenses;
        $bgClass = $netIncome >= 0 ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10';
        $textClass = $netIncome >= 0 ? 'text-success' : 'text-danger';
        ?>
        <div class="mt-4 text-center">
            <h4 class="p-3 rounded <?= $bgClass ?>" style="color: white;">
                Net Income: <span class="<?= $textClass ?>">₱<?= number_format($netIncome, 2) ?></span>
            </h4>
        </div>
    </div>
</div>

</body>
</html>
