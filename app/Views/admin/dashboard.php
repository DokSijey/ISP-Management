<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">

  <title>Admin Dashboard</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      box-shadow: 0 0 15px rgba(220, 53, 69, 0.3);
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
    .card canvas {
  width: 100% !important;
  height: auto !important;
}

.card:hover {
  transform: none;
} 
  </style>
</head>
<body>

<div class="d-flex" style="height: 100vh; overflow: hidden;">
  <?= view('admin/sidebar') ?>

  </header>
  <div class="flex-grow-1 d-flex flex-column" style="overflow-y: auto; background-color:rgba(45, 45, 68, 0.81);">
  <!-- Main Content -->
  <main id="main-content">
    <div class="container-fluid">
      <div class="row g-4">
        <!-- Metric Cards -->
        <div class="col-sm-6 col-md-3">
          <a href="<?= base_url('admin/subscribers') ?>" style="text-decoration: none; color: inherit;">
            <div class="card-metric bg-gradient-1">
              <div>
                <div>Subscribers</div>
                <h2><?= $totalSubscribersCount ?></h2>
              </div>
              <i class="bi bi-people card-icon"></i>
            </div>
          </a>
        </div>
        <div class="col-sm-6 col-md-3">
        <a href="<?= base_url('admin/applications') ?>" style="text-decoration: none; color: inherit;">
          <div class="card-metric bg-gradient-2">
            <div>
              <div>New Applications</div>
              <h2><?= $pendingApplicationsCount ?></h2>
            </div>
            <i class="bi bi-ticket-perforated card-icon"></i>
          </div>
          </a>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="card-metric bg-gradient-3">
            <div>
              <div>Assigned Install / Open Repair Tickets</div>
              <h2><?= $installRequestCount ?> / <?= $assignedRepairTicketCount ?></h2>
            </div>
            <i class="bi bi-check-circle card-icon"></i>
          </div>
        </div>
        <?php
          $monthName = strtoupper(date('F'));
          ?>
        <div class="col-sm-6 col-md-3">
          <div class="card-metric bg-gradient-4">
            <div>
              <div>Collectible for month of <b><?= $monthName ?></b></div>
              <h2>₱ <?= !empty($totalUnpaidAmount) ? number_format($totalUnpaidAmount, 2) : '0.00' ?></h2>
            </div>
            <span class="card-icon" style="font-weight:bold; font-size:3rem;">₱</span>
          </div>
        </div>
      </div>
      <div class="row g-4 mt-2">
        <div class="col-sm-6 col-md-3">
          <div class="card-metric bg-gradient-3">
            <div>
              <div>On-going Install Tickets</div>
              <h2><?= $ongoingRequestCount ?></h2>
            </div>
            <i class="bi bi-check-circle card-icon"></i>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="card-metric bg-gradient-3">
            <div>
              <div>On-going Repair Tickets</div>
              <h2><?= $ongoingRepairTicketCount ?></h2>
            </div>
            <i class="bi bi-check-circle card-icon"></i>
          </div>
        </div>
      <div class="col-sm-6 col-md-3">
          <div class="card-metric bg-gradient-3">
            <div>
              <div>Pending Install Tickets</div>
              <h2><?= $pendinginstallRequestCount ?></h2>
            </div>
            <i class="bi bi-check-circle card-icon"></i>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="card-metric bg-gradient-3">
            <div>
              <div>Pending Repair Tickets</div>
              <h2><?= $pendingRepairTicketCount ?></h2>
            </div>
            <i class="bi bi-check-circle card-icon"></i>
          </div>
        </div>
    </div>

      <!-- Chart -->
    <div class="mt-5">
      <h5>Line Chart for Subscribers per Month</h5>
      <div id="chart-container" class="mt-4">
        <canvas id="lineChart"></canvas>
      </div>
    </div>
    <br>

    <div class="row">
      <!-- Table -->
     <div class="container mt-5">
    <div class="row">
      <!-- Install Tickets Column -->
      <div class="col-md-6">
        <h5>Install Tickets</h5>
        <table class="table table-dark table-hover rounded shadow-sm">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Contact Number</th>
              <th scope="col">Address</th>
              <th scope="col">Plan</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
          <?php if (!empty($installTickets)): ?>
            <?php foreach ($installTickets as $ticket): ?>
              <tr>
                <td><?= esc($ticket['first_name'] . ' ' . $ticket['last_name']) ?></td>
                <td><?= esc($ticket['contact_number1']) ?></td>
                <td><?= esc($ticket['house_number'] . ', ' . $ticket['barangay'] . ', ' . $ticket['city']) ?></td>
                <td><?= esc($ticket['plan']) ?></td>
                <td>
                  <?php 
                    $status = $ticket['app_status'];
                    $badgeClass = 'bg-secondary';
                    if ($status == 'Assigned') {
                        $badgeClass = 'bg-primary';
                    } elseif ($status === 'Cancelled') {
                        $badgeClass = 'bg-danger';
                    } elseif ($status === 'Re-schedule') {
                        $badgeClass = 'bg-warning';
                    } elseif ($status == 'Installed') {
                        $badgeClass = 'bg-success';
                    } elseif ($status == 'On-going') {
                        $badgeClass = 'bg-warning text-dark';
                    }
                  ?>
                  <span class="badge <?= $badgeClass ?>"><?= esc($status) ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center">No install tickets at the moment.</td>
            </tr>
          <?php endif; ?>
        </tbody>
        </table>
      </div>

      <!-- Repair Tickets Column -->
      <div class="col-md-6">
  <h5>Repair Tickets</h5>
  <div style="max-height: 300px; overflow-y: auto; ">
    <table class="table table-dark table-hover rounded shadow-sm">
      <thead>
        <tr>
          <th scope="col">Account Number</th>
          <th scope="col">Subscriber</th>
          <th scope="col">Address</th>
          <th scope="col">Issue</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($repairTickets)): ?>
          <?php foreach ($repairTickets as $ticket): ?>
            <tr>
              <td><?= esc($ticket['account_number'])?></td>
              <td><?= esc($ticket['first_name'] . ' ' . $ticket['middle_name'] . ' ' . $ticket['last_name']) ?></td>
              <td><?= esc($ticket['address'] . ', ' . $ticket['city']) ?></td>
              <td><?= esc($ticket['issue']) ?></td>
              <td>
                <?php
                  $status = $ticket['status'];
                  $badgeClass = 'bg-secondary'; // default
                  switch ($status) {
                    case 'Open':
                      $badgeClass = 'bg-primary';
                      break;
                    case 'Resolved':
                      $badgeClass = 'bg-success';
                      break;
                    case 'Cancelled':
                      $badgeClass = 'bg-danger';
                      break;
                    case 'Re-schedule':
                    case 'On-going':
                      $badgeClass = 'bg-warning text-dark';
                      break;
                  }
                ?>
                <span class="badge <?= $badgeClass ?>"><?= esc($status) ?></span>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="text-center">No repair tickets at the moment.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
<br><br>
</div>

      <!-- Revenues Card -->
      <div class="col-md-6 mb-4">
        <h5>Revenues</h5>
        <div class="card" style="background-color: #1a1a1a; color: #fff; border: 1px solid #dc3545;">
          <div class="card-header" style="background-color: #dc3545; color: #fff; font-weight: bold;">
            Revenue Breakdown for the month of <?= $monthName ?>
          </div>
          <div class="card-body">
            <canvas id="revenuePieChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Expenses Card -->
      <div class="col-md-6 mb-4">
        <h5>Expenses</h5>
        <div class="card" style="background-color: #1a1a1a; color: #fff; border: 1px solid #dc3545;">
          <div class="card-header" style="background-color: #dc3545; color: #fff; font-weight: bold;">
            Expenses Breakdown for the month of <?= $monthName ?>
          </div>
          <div class="card-body">
            <canvas id="expensePieChart"></canvas>
          </div>
        </div>
      </div>
    </div>
    </div>
  </main>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
const labels = <?= $monthsJson ?>;
  const data = <?= $countsJson ?>;

  const ctx = document.getElementById('lineChart').getContext('2d');
  const gradient = ctx.createLinearGradient(0, 0, 0, 400);
  gradient.addColorStop(0, 'rgba(220,53,69,0.6)');
  gradient.addColorStop(1, 'rgba(220,53,69,0)');

  const lineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Subscribers per Month',
        data: data,
        fill: true,
        backgroundColor: gradient,
        borderColor: '#dc3545',
        borderWidth: 3,
        tension: 0.4,
        pointRadius: 5,
        pointBackgroundColor: '#dc3545',
        pointHoverRadius: 7,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          grid: { color: '#2a2a2a' },
          ticks: { color: '#f8f9fa' }
        },
        y: {
          beginAtZero: true,
          grid: { color: '#2a2a2a' },
          ticks: { color: '#f8f9fa' }
        }
      },
      plugins: {
        legend: {
          labels: { color: '#f8f9fa' }
        },
        tooltip: {
          backgroundColor: '#dc3545',
          titleColor: '#fff',
          bodyColor: '#fff',
          cornerRadius: 5
        }
      }
    }
    });
 const revenues = <?= json_encode($revenues); ?>;
  const expenses = <?= json_encode($expenses); ?>;

  // Revenue Pie Chart - green tones
  const revenueCtx = document.getElementById('revenuePieChart').getContext('2d');
  new Chart(revenueCtx, {
    type: 'pie',
    data: {
      labels: Object.keys(revenues),
      datasets: [{
        data: Object.values(revenues),
        backgroundColor: ['#2e7d32', '#4caf50', '#81c784'], // dark to light greens
        borderColor: '#121212',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          labels: { color: '#fff' }
        }
      }
    }
  });

  // Expense Pie Chart - red tones
  const expenseCtx = document.getElementById('expensePieChart').getContext('2d');
  new Chart(expenseCtx, {
    type: 'pie',
    data: {
      labels: Object.keys(expenses),
      datasets: [{
        data: Object.values(expenses),
        backgroundColor: ['#b71c1c', '#e53935', '#f44336'],
        borderColor: '#121212',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          labels: { color: '#fff' }
        }
      }
    }
  });
  </script>
  
</body>
</html>
