<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">

  <meta name="csrf-token-name" content="<?= csrf_token() ?>">
  <meta name="csrf-token-value" content="<?= csrf_hash() ?>">
  <meta name="csrf-token" content="<?= csrf_hash() ?>">
  <title>Technician Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <style>
    body {
      background-color: #121212;
      color: #f0f0f0;
    }
    .navbar {
      background-color: #1f1f1f;
    }
    .card {
      background-color: #1e1e2f;
      color: #ffffff;
    }
    .nav-tabs .nav-link.active {
      background-color: #0d6efd;
      color: #fff;
    }
    .nav-tabs .nav-link {
      color: #9aa0ac;
    }
    .badge.bg-warning {
      background-color: #ffc107;
      color: #000;
    }
    .floating-navbar {
      background: linear-gradient(90deg, #0d1b2a, #1b263b);
      color: white;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
      margin: 16px auto 0 auto;
      padding: 12px 24px;
      max-width: 1300px;
      position: relative;
      z-index: 1000;
    }
    .material-symbols-rounded {
      font-family: 'Material Symbols Rounded';
      font-size: 24px;
    }
    .ongoing-banner {
      background: #1e293b;
      color: #f0f0f0;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
      margin-top: 20px;
    }
    .summary-cards {
      display: flex;
      gap: 1rem;
      margin: 1.5rem 0;
    }
    .summary-card {
      background-color: #1e1e2f;
      padding: 1rem 1.5rem;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      flex: 1;
      text-align: center;
    }
    .clickable-card:hover {
      background-color: #292940;
      transform: scale(1.01);
      transition: 0.2s ease-in-out;
    }
    .bg-cust{
      background-color: #1e1e2f;
      border: 1px solid blue;
    }
  </style>
</head>
<body>

<nav class="floating-navbar d-flex justify-content-between align-items-center px-4 py-3">
  <div class="d-flex align-items-center gap-3">
    <img src="<?= base_url('/assets/images/logo.png') ?>" width="40" height="40" class="rounded-circle" />
    <span class="text-light fw-semibold fs-5"><?= esc($technician['name']) ?> - Technician</span>
  </div>
  <div class="d-none d-md-block text-white text-center">
    <div id="clock" class="fw-bold fs-6"></div>
    <div id="date" class="text-secondary small"></div>
  </div>
  <div class="d-flex justify-content-end align-items-center gap-3">
    <div class="position-relative">
      <span class="text-light fs-6">Area: <?= esc($technician['area']) ?></span>
    </div>
    <a class="btn btn-danger btn-sm" href="<?= base_url('technician/logout') ?>">Logout</a>
  </div>
</nav>

<div class="p-4">
  <div class="container mt-4">

    <div class="summary-cards">
      <div class="summary-card">
        <h6>Pending Installs</h6>
        <h4><?= count($pendingInstalls) ?></h4>
      </div>
      <div class="summary-card">
        <h6>Pending Repairs</h6>
        <h4><?= count($repairTickets) ?></h4>
      </div>
      <div class="summary-card">
        <h6>Ongoing</h6>
        <h4><?= $ongoingTicketData ? '1' : '0' ?></h4>
      </div>
    </div>

    <ul class="nav nav-tabs mb-3" id="ticketTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="install-tab" data-bs-toggle="tab" data-bs-target="#install" type="button" role="tab">Install Tickets</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="repair-tab" data-bs-toggle="tab" data-bs-target="#repair" type="button" role="tab">Repair Tickets</button>
      </li>
    </ul>

    <div class="tab-content" id="ticketTabContent">
      <div class="tab-pane fade show active" id="install" role="tabpanel">
        <div class="card p-3">
          <h5>Pending Install Requests</h5>
          <?php if (!empty($pendingInstalls)): ?>
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mt-3">
            <?php foreach ($pendingInstalls as $install): ?>
              <div class="col">
                <div class="card h-100 p-3 bg-dark text-light border border-secondary shadow-sm clickable-card">
                  <div class="d-flex justify-content-between align-items-start">
                    <div>
                      <h6 class="mb-1"><?= esc($install['app_first_name'] . ' ' . $install['app_last_name']) ?></h6>
                      <small class="text-secondary">Address: <?= esc($install['house_number'] . ' ' . $install['apartment'] . ' ' . $install['barangay'] . ', ' . $install['city']) ?></small>
                    </div>
                    <span class="badge bg-warning text-dark">Pending</span>
                  </div>
                  <hr class="border-secondary" />
                  <p class="mb-1"><strong>Contact:</strong> <?= esc($install['contact_number1']) ?></p>
                  <p class="mb-1"><strong>Landmark:</strong> <?= esc($install['landmark']) ?></p>
                  <div class="d-flex justify-content-between align-items-center mt-2">
                  <span class="small text-info">Scheduled: <?= esc(date('F j, Y', strtotime($install['schedule_date']))) ?></span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#installDetailsModal<?= $install['id'] ?>">Details</button>
                  </div>
                </div>
              </div>
              <!-- MODAL INSTALL TICKET -->
  <div class="modal fade" id="installDetailsModal<?= $install['id'] ?>" tabindex="-1" aria-labelledby="installDetailsModalLabel<?= $install['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
      <div class="modal-content bg-dark border border-primary rounded-4 shadow-lg">
        <div class="modal-header border-bottom border-primary text-light">
          <h5 class="modal-title fw-semibold d-flex align-items-center" id="installDetailsModalLabel<?= $install['id'] ?>">
            <i class="bi bi-hammer me-2 text-primary fs-5"></i> Installation Ticket Details
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body text-light px-4 py-3">
          <div class="row g-3">
            <div class="col-md-7">
              <div><strong class="text-info">Name:</strong> <?= esc($install['app_first_name'] . ' ' . $install['app_last_name']) ?></div>
              <div><strong class="text-info">Email:</strong> <?= esc($install['email']) ?></div>
              <div><strong class="text-info">Contact #:</strong> <?= esc($install['contact_number1']) ?></div>
              <div><strong class="text-info">Address:</strong><?= esc($install['house_number'] . ' ' . $install['apartment'] . ' ' . $install['barangay'] . ', ' . $install['city']) ?></div>
              <div><strong class="text-info">Landmark:</strong> <?= esc($install['landmark']) ?></div>
            </div>
            <div class="col-md-5">
              <div><strong class="text-info">Scheduled Date:</strong> <?= esc(date('F j, Y', strtotime($install['schedule_date']))) ?></div>
              <div><strong class="text-info">Status:</strong> <span class="badge bg-warning text-dark"><?= esc($install['status']) ?></span></div>
              <div><strong class="text-info">Plan:</strong> <?= esc($install['plan']) ?></div>
            </div>
            </div>
            </div>

        <div class="modal-footer border-top border-primary d-flex text-end">
          <div>
            <button type="button" class="btn btn-primary btn-sm me-1" onclick="startInstall(<?= $install['application_id'] ?>)">
              <i class="bi bi-play-circle me-1"></i>Start
            </button>
            <button type="button" class="btn btn-warning btn-sm me-1" onclick="rescheduleInstall(<?= $install['application_id'] ?>)">
              <i class="bi bi-calendar-event me-1"></i>Re-schedule
            </button>
            <button type="button" class="btn btn-danger btn-sm" onclick="cancelInstall(<?= $install['application_id'] ?>)">
              <i class="bi bi-x-circle me-1"></i>Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- END modal -->
            <?php endforeach; ?>
          </div>
          <?php else: ?>
            <div class="alert alert-info mt-3">No pending install requests at the moment.</div>
          <?php endif; ?>
        </div>
      </div>
<div class="tab-pane fade" id="repair" role="tabpanel">
  <div class="card p-3">
    <h5>Pending Repair Tickets</h5>
    <?php if (!empty($repairTickets)): ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mt-3">
      <?php foreach ($repairTickets as $ticket): ?>
        <div class="col">
          <div class="card h-100 p-3 bg-dark text-light border border-secondary shadow-sm">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h6 class="mb-1"><?= esc($ticket['sub_first_name'] . ' ' . $ticket['sub_last_name']) ?></h6>
                <small class="text-secondary">Acct #: <?= esc($ticket['account_number']) ?></small>
              </div>
              <span class="badge 
                <?= $ticket['status'] === 'On-going' ? 'bg-primary' : ($ticket['status'] === 'Open' ? 'bg-warning text-dark' : 'bg-secondary') ?>">
                <?= esc($ticket['status']) ?>
              </span>
            </div>
            <hr class="border-secondary" />
            <p class="mb-1"><strong>Issue:</strong> <?= esc($ticket['issue']) ?></p>
            <p class="small text-light"><?= esc($ticket['description']) ?></p>
            <div class="d-flex justify-content-between align-items-center mt-2">
              <span class="small text-info">Scheduled: <?= esc(date('F j, Y', strtotime($ticket['scheduled_date']))) ?></span>
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#ticketModal<?= $ticket['id'] ?>">
                Details
              </button>
            </div>
          </div>
        </div>

 <!-- Modal -->
<div class="modal fade" id="ticketModal<?= $ticket['id'] ?>" tabindex="-1" aria-labelledby="ticketModalLabel<?= $ticket['id'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content bg-dark border border-primary rounded-4 shadow-lg">
      <div class="modal-header border-bottom border-primary text-light">
        <h5 class="modal-title fw-semibold d-flex align-items-center" id="ticketModalLabel<?= $ticket['id'] ?>">
          <i class="bi bi-tools me-2 text-primary fs-5"></i> Ticket Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body text-light px-4 py-3">
        <div class="row g-3">
          <div class="col-md-6">
            <div><strong class="text-info">Subscriber:</strong> <?= esc($ticket['sub_first_name'] . ' ' . $ticket['sub_last_name']) ?></div>
            <div><strong class="text-info">Account #:</strong> <?= esc($ticket['account_number']) ?></div>
            <div class="d-flex align-items-center mt-2">
              <strong class="text-info me-2">Address:</strong>
              <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($ticket['address'] . ', ' . $ticket['city']) ?>" 
                target="_blank"
                class="text-light text-decoration-none">
                <?= esc($ticket['address'] . ', ' . $ticket['city']) ?>
              </a>
            </div>
          </div>

          <div class="col-md-6">
            <div><strong class="text-info">Status:</strong> <span class="badge bg-primary"><?= esc($ticket['status']) ?></span></div>
            <div><strong class="text-info">Scheduled Date:</strong> <?= esc(date('F j, Y', strtotime($ticket['scheduled_date']))) ?></div>
            <div><strong class="text-info">Maps: </strong>
            <a href="https://www.google.com/maps/dir/?api=1&destination=<?= urlencode($ticket['address'] . ', ' . $ticket['city']) ?>"
                target="_blank"
                class="ms-3">
                <span class="badge bg-success text-light">Get Directions <i class="bi bi-geo-alt-fill me-1"></i>
                </span>
              </a>
              </div>
          </div>

          <div class="col-12">
          <div><strong class="text-info">Issue:</strong> <?= esc($ticket['issue']) ?></div>
            <strong class="text-info">Description:</strong>
            <div class="bg-secondary bg-opacity-25 text-light p-3 rounded small mt-1">
              <b><?= esc($ticket['description']) ?></b>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer border-top border-primary d-flex justify-content-between">
        <span class="text-light small">Last Updated: <?= esc(date('F j, Y h:i A', strtotime($ticket['updated_at'] ?? 'now'))) ?></span>
        <div>
          <button type="button" class="btn btn-primary btn-sm me-1" onclick="startTicket(<?= $ticket['id'] ?>)">
            <i class="bi bi-play-circle me-1"></i>Start
          </button>
          <button type="button" class="btn btn-warning btn-sm me-1" onclick="rescheduleTicket(<?= $ticket['id'] ?>)">
            <i class="bi bi-calendar-event me-1"></i>Re-schedule
          </button>
          <button type="button" class="btn btn-danger btn-sm" onclick="cancelTicket(<?= $ticket['id'] ?>)">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</div>


      <?php endforeach; ?>
    </div>
    <?php else: ?>
      <div class="alert alert-info mt-3">No repair tickets at the moment.</div>
    <?php endif; ?>
  </div>
</div>

<div class="card p-3 mt-4">
        <h5 class="mb-3">Tickets Overview</h5>
        <canvas id="ticketChart" height="100"></canvas>
    </div>
    </div>
  </div>
</div>

<!-- FOR REPAIR MATERIAL REPORTING -->
<div class="modal fade" id="materialsModal" tabindex="-1" aria-labelledby="materialsLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-xl">
    <form id="materialsForm" method="post" action="<?= base_url('technician/submitMaterialsReport') ?>" class="modal-content bg-dark text-white border-0 shadow-lg rounded-3" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrfTokenField">
      <input type="hidden" id="materialsRepairId" name="repair_id" value="">
      <input type="hidden" name="status" id="ticketStatus" value="">
      <input type="hidden" name="reason" id="ticketReason" value="">

      <!-- Modal Header -->
      <div class="modal-header bg-primary text-white rounded-top">
        <h5 class="modal-title fw-bold" id="materialsLabel">
          🧾 Materials Report - Account #: <span id="ticketAccountNumber" class="text-warning"></span>
          <?= isset($ongoingTicketData['account_number']) ? esc($ongoingTicketData['account_number']) : '' ?>
        </h5>
        <button type="button" class="btn-close btn-close-white" id="materialsModalCloseBtn" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body px-4">

        <!-- Section: Materials -->
        <div class="rounded-4 p-4 mb-4" style="background-color: #111827; border: 1px solid #2563eb;">
          <h6 class="fw-bold text-primary mb-3">📦 Materials Used</h6>
          <div class="row g-3">
            <div class="col-md-4">
              <label for="modemQty" class="form-label">Modem (qty)</label>
              <input type="number" class="form-control bg-dark border-primary text-white" id="modemQty" name="modem_qty" min="0" required>
            </div>
            <div class="col-md-4">
              <label for="focQty" class="form-label">FOC (qty)</label>
              <input type="number" class="form-control bg-dark border-primary text-white" id="focQty" name="foc_qty" min="0" required>
            </div>
            <div class="col-md-4">
              <label for="ficQty" class="form-label">FIC (qty)</label>
              <input type="number" class="form-control bg-dark border-primary text-white" id="ficQty" name="fic_qty" min="0" required>
            </div>
            <div class="col-12">
              <label for="materialsOthers" class="form-label">Others (specify)</label>
              <input type="text" class="form-control bg-dark border-primary text-white" id="materialsOthers" name="materials_others" required>
            </div>
          </div>
        </div>

        <!-- Section: Troubleshooting -->
        <div class="rounded-4 p-4 mb-4" style="background-color: #111827; border: 1px solid #2563eb;">
          <h6 class="fw-bold text-primary mb-3">🛠️ Troubleshooting</h6>
          <div class="mb-3">
            <label for="trouble" class="form-label">Trouble Description</label>
            <textarea class="form-control bg-dark border-primary text-white" id="trouble" name="trouble" rows="2" required></textarea>
          </div>
          <div>
            <label for="actionTaken" class="form-label">Action Taken</label>
            <textarea class="form-control bg-dark border-primary text-white" id="actionTaken" name="action_taken" rows="2" required></textarea>
          </div>
        </div>

        <!-- Section: Uploads -->
        <div class="rounded-4 p-4 mb-4" style="background-color: #111827; border: 1px solid #2563eb;">
          <h6 class="fw-bold text-primary mb-3">📷 Required Uploads</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Power Meter Reading - NAP</label>
              <input type="file" class="form-control bg-dark border-primary text-white" name="power_nap" accept="image/*" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">NAP Picture</label>
              <input type="file" class="form-control bg-dark border-primary text-white" name="nap_picture" accept="image/*" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">GUI PON Info (screenshot)</label>
              <input type="file" class="form-control bg-dark border-primary text-white" name="gui_pon" accept="image/*" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Speedtest (screenshot)</label>
              <input type="file" class="form-control bg-dark border-primary text-white" name="speedtest" accept="image/*" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Power Meter Reading - Grounds</label>
              <input type="file" class="form-control bg-dark border-primary text-white" name="power_ground" accept="image/*" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Picture with Subscriber</label>
              <input type="file" class="form-control bg-dark border-primary text-white" name="with_subscriber" accept="image/*" required>
            </div>
            <div class="col-md-12">
              <label class="form-label">Picture of House</label>
              <input type="file" class="form-control bg-dark border-primary text-white" name="house_picture" accept="image/*" required>
            </div>
          </div>
        </div>

        <!-- Section: Tagging & Serial -->
        <div class="rounded-4 p-4 mb-4" style="background-color: #111827; border: 1px solid #2563eb;">
          <h6 class="fw-bold text-primary mb-3">📌 Tagging & Serial Number</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="tagging" class="form-label">Tagging (specify)</label>
              <input type="text" class="form-control bg-dark border-primary text-white" id="tagging" name="tagging" required>
            </div>
            <div class="col-md-6">
              <label for="serialNumber" class="form-label">Modem Serial Number</label>
              <input type="text" class="form-control bg-dark border-primary text-white" id="serialNumber" name="serial_number" required>
            </div>
          </div>
        </div>

      </div>

      <!-- Modal Footer -->
      <div class="modal-footer bg-dark border-top border-primary d-flex flex-column">
        <button type="submit" class="btn btn-primary w-100 fw-bold" name="submit_type" value="submit_report" id="materialsSubmitBtn">
          📨 Submit Materials Report
        </button>
      </div>
    </form>
  </div>
</div>


<!-- Install Materials Reporting Modal -->
<div class="modal fade" id="installMaterialsModal" tabindex="-1" aria-labelledby="installMaterialsLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-xl">
    <form id="installMaterialsForm" method="post" action="<?= base_url('technician/submitInstallMaterials') ?>" class="modal-content bg-dark text-white border-0 shadow-lg rounded-3 p-3" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrfTokenField">
      <input type="hidden" id="installRequestId" name="install_id" value="<?= isset($ongoingRequest['application_id']) ? $ongoingRequest['application_id'] : '' ?>">

      <!-- Modal Header -->
      <div class="modal-header bg-success text-white rounded-top">
      <h5 class="modal-title fw-bold" id="installMaterialsLabel">
    🧾 Installation Report - Account Name:
    <?= esc(($ongoingTicketData['app_first_name'] ?? '') . ' ' . ($ongoingTicketData['app_last_name'] ?? '')) ?>
    </h5>

          <button type="button" class="btn-close btn-close-white" id="installMaterialsModalCloseBtn" aria-label="Close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body px-4">

        <!-- Section: Materials -->
        <div class="rounded-4 p-4 mb-4" style="background-color: #111827; border: 1px solid #16a34a;">
          <h6 class="fw-bold text-success mb-3">📦 Materials Used</h6>
          <div class="row g-3">
            <div class="col-md-4">
              <label for="modemQty" class="form-label">Modem (qty)</label>
              <input type="number" class="form-control bg-dark border-success text-white" id="modemQty" name="modem_qty" min="0" required>
            </div>
            <div class="col-md-4">
              <label for="focQty" class="form-label">FOC (qty)</label>
              <input type="number" class="form-control bg-dark border-success text-white" id="focQty" name="foc_qty" min="0" required>
            </div>
            <div class="col-md-4">
              <label for="ficQty" class="form-label">FIC (qty)</label>
              <input type="number" class="form-control bg-dark border-success text-white" id="ficQty" name="fic_qty" min="0" required>
            </div>
            <div class="col-12">
              <label for="materialsOthers" class="form-label">Others (specify)</label>
              <input type="text" class="form-control bg-dark border-success text-white" id="materialsOthers" name="materials_others" required>
            </div>
            <div class="col-12">
              <label for="remarks" class="form-label">Remarks</label>
              <textarea class="form-control bg-dark border-success text-white" id="remarks" name="remarks" rows="2" required></textarea>
            </div>
          </div>
        </div>

        <!-- Section: Uploads -->
        <div class="rounded-4 p-4 mb-4" style="background-color: #111827; border: 1px solid #16a34a;">
          <h6 class="fw-bold text-success mb-3">📷 Required Uploads</h6>
          <div class="row g-3">
            <?php
              $uploads = [
                'power_nap' => 'Power Meter Reading - NAP',
                'nap_picture' => 'NAP Picture',
                'gui_pon' => 'GUI PON Info (screenshot)',
                'speedtest' => 'Speedtest (screenshot)',
                'power_ground' => 'Power Meter Reading - Grounds',
                'with_subscriber' => 'Picture with Subscriber',
                'picture_of_id' => 'Picture of Subscriber ID',
                'picture_of_page' => 'Picture of Signed Page',
                'house_picture' => 'Picture of House',
              ];
              foreach ($uploads as $name => $label):
            ?>
            <div class="col-md-<?= $name === 'house_picture' ? '12' : '6' ?>">
              <label class="form-label"><?= $label ?></label>
              <input type="file" class="form-control bg-dark border-success text-white" name="<?= $name ?>" accept="image/*" required>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Section: Serial -->
        <div class="rounded-4 p-4 mb-4" style="background-color: #111827; border: 1px solid #16a34a;">
          <h6 class="fw-bold text-success mb-3">📌 Serial Number</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="serialNumber" class="form-label">Modem Serial Number</label>
              <input type="text" class="form-control bg-dark border-success text-white" id="serialNumber" name="serial_number" required>
            </div>
          </div>
        </div>

      </div>

      <!-- Modal Footer -->
      <div class="modal-footer bg-dark border-top border-success d-flex flex-column">
        <button type="submit" class="btn btn-success w-100 fw-bold" id="installMaterialsSubmitBtn">
          📨 Submit Installation Report
        </button>
      </div>

    </form>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
<script>
  function updateClockAndDate() {
    const now = new Date();
    const clock = now.toLocaleTimeString();
    const date = now.toLocaleDateString(undefined, { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    document.getElementById('clock').textContent = clock;
    document.getElementById('date').textContent = date;
  }
  setInterval(updateClockAndDate, 1000);
  updateClockAndDate();

  const ctx = document.getElementById('ticketChart').getContext('2d');
  const ticketChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Install', 'Repair', 'Ongoing'],
      datasets: [{
        label: 'Tickets',
        data: [<?= count($pendingInstalls) ?>, <?= count($repairTickets) ?>, <?= $ongoingTicketData ? 1 : 0 ?>],
        backgroundColor: ['#0d6efd', '#ffc107', '#28a745'],
        borderRadius: 8
      }]
    },
    options: {
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: { beginAtZero: true, ticks: { color: '#ccc' }, grid: { color: '#333' } },
        x: { ticks: { color: '#ccc' }, grid: { color: '#333' } }
      }
    }
  });

  //start ticket
  function startTicket(ticketId) {
  const csrfName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content');
  const csrfHash = document.querySelector('meta[name="csrf-token-value"]').getAttribute('content');

  Swal.fire({
    title: 'Start this ticket?',
    text: "This will set the status to 'On-going'.",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, start it!',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#0d6efd',
    cancelButtonColor: '#6c757d',
    background: '#1e1e2f',
    color: '#fff'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch("<?= base_url('technician/updateRepairStatus') ?>", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
          "X-Requested-With": "XMLHttpRequest"
        },
        body: new URLSearchParams({
          repair_id: ticketId,
          status: 'On-going',
          [csrfName]: csrfHash // ✅ CSRF token injected here
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            title: 'Ticket Started!',
            text: 'This ticket is now marked as On-going.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#0d6efd',
            background: '#1e1e2f',
            color: '#fff'
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire('Error', data.message, 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Something went wrong. Try again.', 'error');
      });
    }
  });
}
function rescheduleTicket(ticketId) {
  // Hide any open modals
  const openModal = document.querySelector('.modal.show');
  if (openModal) {
    const modalInstance = bootstrap.Modal.getInstance(openModal);
    modalInstance.hide();
  }

  // Now show SweetAlert after modal is hidden
  setTimeout(() => {
    const csrfName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content');
    const csrfHash = document.querySelector('meta[name="csrf-token-value"]').getAttribute('content');

    Swal.fire({
      title: 'Re-schedule Ticket',
      input: 'textarea',
      inputLabel: 'Reason for Re-scheduling',
      inputPlaceholder: 'Enter the reason...',
      inputAttributes: {
        'aria-label': 'Re-schedule reason'
      },
      inputValidator: (value) => {
        if (!value) return 'Please enter a reason!';
      },
      showCancelButton: true,
      confirmButtonText: 'Submit',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#f0ad4e',
      cancelButtonColor: '#6c757d',
      background: '#1e1e2f',
      color: '#fff'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("<?= base_url('technician/updateRepairStatus') ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
          },
          body: new URLSearchParams({
            repair_id: ticketId,
            status: 'Re-schedule',
            reason: result.value,
            [csrfName]: csrfHash
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              title: 'Ticket Re-scheduled!',
              text: 'Status updated with reason.',
              icon: 'success',
              confirmButtonColor: '#f0ad4e',
              background: '#1e1e2f',
              color: '#fff'
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire('Error', 'Something went wrong. Try again.', 'error');
        });
      }
    });
  }, 300); // Delay to allow modal to finish closing
}
function cancelTicket(ticketId) {
  // Hide any open modals
  const openModal = document.querySelector('.modal.show');
  if (openModal) {
    const modalInstance = bootstrap.Modal.getInstance(openModal);
    modalInstance.hide();
  }

  // Delay to allow modal to close before SweetAlert opens
  setTimeout(() => {
    const csrfName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content');
    const csrfHash = document.querySelector('meta[name="csrf-token-value"]').getAttribute('content');

    Swal.fire({
      title: 'Cancel Ticket',
      input: 'textarea',
      inputLabel: 'Reason for Cancellation',
      inputPlaceholder: 'Enter the reason...',
      inputAttributes: {
        'aria-label': 'Cancel reason'
      },
      inputValidator: (value) => {
        if (!value) return 'Please enter a reason!';
      },
      showCancelButton: true,
      confirmButtonText: 'Submit',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      background: '#1e1e2f',
      color: '#fff'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("<?= base_url('technician/updateRepairStatus') ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
          },
          body: new URLSearchParams({
            repair_id: ticketId,
            status: 'Cancelled',
            reason: result.value,
            [csrfName]: csrfHash
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              title: 'Ticket Cancelled!',
              text: 'Status updated with reason.',
              icon: 'success',
              confirmButtonColor: '#dc3545',
              background: '#1e1e2f',
              color: '#fff'
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire('Error', 'Something went wrong. Try again.', 'error');
        });
      }
    });
  }, 300);
}

function startInstall(installId) {
  const csrfName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content');
  const csrfHash = document.querySelector('meta[name="csrf-token-value"]').getAttribute('content');
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


  Swal.fire({
    title: 'Start this installation?',
    text: "This will set the status to 'On-going'.",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, start it!',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#0d6efd',
    cancelButtonColor: '#6c757d',
    background: '#1e1e2f',
    color: '#fff'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch("<?= base_url('technician/updateStatus') ?>", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
          "X-Requested-With": "XMLHttpRequest"
        },
        body: new URLSearchParams({
          application_id: installId,
          app_status: 'On-going',
          [csrfName]: csrfHash
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            title: 'Installation Started!',
            text: 'This installation is now marked as On-going.',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#0d6efd',
            background: '#1e1e2f',
            color: '#fff'
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire('Error', data.message, 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Something went wrong. Try again.', 'error');
      });
    }
  });
}

function rescheduleInstall(installId) {
  const openModal = document.querySelector('.modal.show');
  if (openModal) {
    const modalInstance = bootstrap.Modal.getInstance(openModal);
    modalInstance.hide();
  }

  setTimeout(() => {
    const csrfName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content');
    const csrfHash = document.querySelector('meta[name="csrf-token-value"]').getAttribute('content');

    Swal.fire({
      title: 'Re-schedule Installation',
      input: 'textarea',
      inputLabel: 'Reason for Re-scheduling',
      inputPlaceholder: 'Enter the reason...',
      inputAttributes: {
        'aria-label': 'Re-schedule reason'
      },
      inputValidator: (value) => {
        if (!value) return 'Please enter a reason!';
      },
      showCancelButton: true,
      confirmButtonText: 'Submit',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#f0ad4e',
      cancelButtonColor: '#6c757d',
      background: '#1e1e2f',
      color: '#fff'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("<?= base_url('technician/updateStatus') ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
          },
          body: new URLSearchParams({
            application_id: installId,
            app_status: 'Re-schedule',
            app_reason: result.value,
            [csrfName]: csrfHash
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              title: 'Installation Re-scheduled!',
              text: 'Status updated with reason.',
              icon: 'success',
              confirmButtonColor: '#f0ad4e',
              background: '#1e1e2f',
              color: '#fff'
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire('Error', 'Something went wrong. Try again.', 'error');
        });
      }
    });
  }, 300);
}

function cancelInstall(installId) {
  const openModal = document.querySelector('.modal.show');
  if (openModal) {
    const modalInstance = bootstrap.Modal.getInstance(openModal);
    modalInstance.hide();
  }

  setTimeout(() => {
    const csrfName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content');
    const csrfHash = document.querySelector('meta[name="csrf-token-value"]').getAttribute('content');

    Swal.fire({
      title: 'Cancel Installation',
      input: 'textarea',
      inputLabel: 'Reason for Cancellation',
      inputPlaceholder: 'Enter the reason...',
      inputAttributes: {
        'aria-label': 'Cancel reason'
      },
      inputValidator: (value) => {
        if (!value) return 'Please enter a reason!';
      },
      showCancelButton: true,
      confirmButtonText: 'Submit',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      background: '#1e1e2f',
      color: '#fff'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("<?= base_url('technician/updateStatus') ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
          },
          body: new URLSearchParams({
            application_id: installId,
            app_status: 'Cancelled',
            app_reason: result.value,
            [csrfName]: csrfHash
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              title: 'Installation Cancelled!',
              text: 'Status updated with reason.',
              icon: 'success',
              confirmButtonColor: '#dc3545',
              background: '#1e1e2f',
              color: '#fff'
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire('Error', 'Something went wrong. Try again.', 'error');
        });
      }
    });
  }, 300);
}


const ongoingRepairId = <?= isset($ongoingRepair['id']) ? json_encode($ongoingRepair['id']) : 'null' ?>;
const ongoingInstallId = <?= ($ongoingTicketType === 'install' && isset($ongoingTicketData['application_id'])) ? json_encode($ongoingTicketData['application_id']) : 'null' ?>;
document.addEventListener('DOMContentLoaded', function () {
  const ongoingType = <?= isset($ongoingTicketType) ? json_encode($ongoingTicketType) : 'null' ?>;
  const ongoingId = <?= isset($ongoingTicketData['id']) ? json_encode($ongoingTicketData['id']) : 'null' ?>;

  console.log("JS loaded with type:", ongoingType, "and ID:", ongoingId);

  if (ongoingType && ongoingId) {
    if (ongoingType === 'repair') {
      const input = document.getElementById('materialsRepairId');
      const modal = new bootstrap.Modal(document.getElementById('materialsModal'));

      if (input && modal) {
        input.value = ongoingId;
        modal.show();
        console.log("Repair modal should now be shown");
      } else {
        console.error("Repair modal or input not found!");
      }
    }

    if (ongoingType === 'install') {
      const input = document.getElementById('installRequestId');
      const modal = new bootstrap.Modal(document.getElementById('installMaterialsModal'));

      if (input && modal) {
        input.value = ongoingId;
        modal.show();
        console.log("Install modal should now be shown");
      } else {
        console.error("Install modal or input not found!");
      }
    }
  }
});
document.addEventListener('DOMContentLoaded', () => {
    const closeBtn = document.getElementById('materialsModalCloseBtn');
    const materialsModalElement = document.getElementById('materialsModal');
    const materialsModal = new bootstrap.Modal(materialsModalElement);

    closeBtn?.addEventListener('click', () => {
        const currentRepairId = document.getElementById('materialsRepairId')?.value;

        if (!currentRepairId) {
            console.error('No repair ID to update.');
            materialsModal.hide();
            return;
        }

        const formData = new FormData();
        formData.append('repair_id', currentRepairId);
        formData.append('status', 'Open');
        formData.append('reason', '');
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        fetch("<?= base_url('technician/updateRepairStatus') ?>", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Ticket Reopened',
                    text: data.message,
                    confirmButtonColor: '#0d6efd',
                    background: '#1e1e2f',
                    color: '#ffffff',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to update status.',
                    background: '#1e1e2f',
                    color: '#ffffff',
                });
            }
        })
        .catch(() => Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Request failed',
            background: '#1e1e2f',
            color: '#ffffff',
        }));
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const closeBtn = document.getElementById('installMaterialsModalCloseBtn');
    const modalElement = document.getElementById('installMaterialsModal');
    const installModal = new bootstrap.Modal(modalElement);

    closeBtn?.addEventListener('click', () => {
        const installId = document.getElementById('installRequestId')?.value;

        if (!installId) {
            console.error('No install ID to update.');
            installModal.hide();
            return;
        }

        const formData = new FormData();
        formData.append('install_id', installId);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        fetch("<?= base_url('technician/set-status-open') ?>", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Status Updated',
                    text: data.message,
                    confirmButtonColor: '#0d6efd',
                    background: '#1e1e2f',
                    color: '#ffffff',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to update status.',
                    background: '#1e1e2f',
                    color: '#ffffff',
                });
            }
        })
        .catch(() => Swal.fire({
            icon: 'error',
            title: 'Request Error',
            text: 'Something went wrong.',
            background: '#1e1e2f',
            color: '#ffffff',
        }));
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const materialsForm = document.getElementById('materialsForm');
    const materialsModalElement = document.getElementById('materialsModal');
    const materialsModal = new bootstrap.Modal(materialsModalElement);

    if (materialsForm) {
        materialsForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('<?= base_url('technician/submitMaterialsReport') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Report Submitted',
                        text: data.message,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#0d6efd',
                        background: '#1e1e2f',
                        color: '#ffffff',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed',
                        text: data.message || 'Please check your input and try again.',
                        background: '#1e1e2f',
                        color: '#ffffff',
                    });

                    if (data.errors) {
                        console.error('Validation Errors:', data.errors);
                    }
                }
            })
            .catch(error => {
                console.error('Submission Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Request Error',
                    text: 'Something went wrong: ' + error.message,
                    background: '#1e1e2f',
                    color: '#ffffff',
                });
            });
        });
    }
});
document.addEventListener('DOMContentLoaded', () => {
    const installForm = document.getElementById('installMaterialsForm');
    const installModalElement = document.getElementById('installMaterialsModal');
    const installModal = new bootstrap.Modal(installModalElement);

    if (installForm) {
        installForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Show loading alert
            Swal.fire({
                title: 'Submitting...',
                text: 'Please wait while your report is being processed.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                background: '#1e1e2f',
                color: '#ffffff',
            });

            fetch('<?= base_url('technician/submitInstallMaterials') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                Swal.close(); // Close loading

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Installation Report Submitted',
                        text: data.message,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#16a34a',
                        background: '#1e1e2f',
                        color: '#ffffff',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed',
                        text: data.message || 'Please check your inputs and try again.',
                        background: '#1e1e2f',
                        color: '#ffffff',
                    });

                    if (data.errors) {
                        console.error('Validation Errors:', data.errors);
                    }
                }
            })
            .catch(error => {
                Swal.close(); // Close loading on error
                console.error('Submission Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Request Error',
                    text: 'Something went wrong: ' + error.message,
                    background: '#1e1e2f',
                    color: '#ffffff',
                });
            });
        });
    }
});

</script> 
</body>
</html>
