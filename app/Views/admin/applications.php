<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token-name" content="<?= csrf_token() ?>">
    <meta name="csrf-token-value" content="<?= csrf_hash() ?>">
        <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">
    <title>Manage Applications</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
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
    /* Modal background black */
#editSubscriberModal .modal-content {
  background-color: #121212; /* very dark black */
  border-radius: 1rem;
  color: #fff;
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

      <div class="container py-4">
        <div class="card shadow rounded-4" style="background: var(--dark-gray); border: none;">
          <div class="card-header rounded-top-4" style="background-color: var(--red); color: var(--text-light);">
            <h4 class="mb-0">Application Lists</h4>
          </div>
          <div class="card-body">

            <!-- Table 1 -->
            <h5 class="mb-3" style="color: var(--text-light);">Pending Applications</h5>
            <div class="table-responsive mb-4" style="max-height: 300px; overflow-y: auto;">
              <table class="table table-dark table-hover text-center align-middle small">
                <thead style="color: var(--red); border-bottom: 2px solid var(--red);">
                  <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(empty($pendingApplications)): ?>
                    <tr><td colspan="5" class="text-center" style="color: var(--text-light);">No pending applications.</td></tr>
                  <?php else: ?>
                    <?php foreach ($pendingApplications as $app): ?>
                      <tr style="background-color: #1e1e1e; border-radius: 10px;">
                        <td><?= esc($app['first_name'] . ' ' . $app['last_name']) ?></td>
                        <td><?= esc($app['barangay'] . ', ' . $app['city']) ?></td>
                        <td><?= esc($app['plan']) ?></td>
                        <td><span class="badge" style="background-color: #f56264; color: var(--black); font-weight: 600;">Pending</span></td>
                        <td>
                          <button class="btn btn-sm admit-btn" style="background-color:rgb(0, 78, 7); color: var(--text-light); font-weight: 600; margin-right: 0.5rem;" data-id="<?= esc($app['id']) ?>">Admit</button>
                          <button class="btn btn-sm decline-btn" style="background-color: var(--red); color: var(--text-light); font-weight: 600;" data-id="<?= esc($app['id']) ?>" data-bs-toggle="modal" data-bs-target="#declineModal">Decline</button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>

            <!-- Table 2 -->
            <h5 class="mb-3" style="color:rgb(255, 255, 255);">Approved Applications</h5>
            <div class="table-responsive mb-4" style="max-height: 300px; overflow-y: auto;">
              <table class="table table-dark table-hover text-center align-middle small">
                <thead style="color: #28a745; border-bottom: 2px solid #28a745;">
                  <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Schedule</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(empty($approvedApplications)): ?>
                    <tr><td colspan="6" class="text-center" style="color: var(--text-light);">No approved applications.</td></tr>
                  <?php else: ?>
                    <?php foreach ($approvedApplications as $app): ?>
                      <tr style="background-color: #1e1e1e; border-radius: 10px;">
                        <td><?= esc($app['first_name'] . ' ' . $app['last_name']) ?></td>
                        <td><?= esc($app['barangay'] . ', ' . $app['city']) ?></td>
                        <td><?= esc($app['plan']) ?></td>
                        <td><span class="badge" style="background-color: #28a745; font-weight: 600;">Approved</span></td>
                        <td>
                      <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_token">
                      <input type="date" id="schedule_date_<?= esc($app['id']) ?>" name="schedule_date" required class="form-control form-control-sm schedule-input" id="schedule_<?= esc($app['id']) ?>" style="background-color: #1e1e1e; border: 1px solid var(--red); color: var(--text-light);">
                    </td>
                    <td>
                      <button class="btn btn-success btn-sm" onclick="sendToTechnician(<?= esc($app['id']) ?>)" style="background-color:rgb(0, 183, 255); color: var(--black); font-weight: 600;">
                        Send to Technician
                      </button>
                    </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>

            <!-- Table 3 -->
            <h5 class="mb-3" style="color:rgb(255, 255, 255);">Declined Applications</h5>
            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
              <table class="table table-dark table-hover text-center align-middle small">
                <thead style="color: #dc3545; border-bottom: 2px solid #dc3545;">
                  <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Reason</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(empty($declinedApplications)): ?>
                    <tr><td colspan="6" class="text-center" style="color: var(--text-light);">No declined applications.</td></tr>
                  <?php else: ?>
                    <?php foreach ($declinedApplications as $app): ?>
                      <tr style="background-color: #1e1e1e; border-radius: 10px;">
                        <td><?= esc($app['first_name'] . ' ' . $app['last_name']) ?></td>
                        <td><?= esc($app['barangay'] . ', ' . $app['city']) ?></td>
                        <td><?= esc($app['plan']) ?></td>
                        <td><span class="badge" style="background-color: #dc3545; font-weight: 600;">Declined</span></td>
                        <td><?= esc($app['decline_reason']) ?></td>
                        <td>
                          <button class="btn btn-sm admit-btn" style="background-color: var(--red-light); color: var(--black); font-weight: 600;" data-id="<?= esc($app['id']) ?>">Re-Admit</button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Decline Reason Modal -->
<div class="modal fade" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title fw-bold" id="declineModalLabel">Decline Application</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="declineForm" class="p-3">
        <input type="hidden" id="decline_id" name="id">
        <div class="mb-3">
          <label for="reason" class="form-label fw-semibold" style="color: var(--black);">Reason for Declining</label>
          <textarea id="reason" name="reason" class="form-control" rows="4" placeholder="Please provide the reason..." required></textarea>
        </div>
        <div class="d-flex justify-content-end gap-2">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDecline">
            <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
            Confirm
          </button>
        </div>
      </form>
    </div>
  </div>
</div>



<script>
    function showSwal(title, text, icon = "info") {
        return Swal.fire({
            title: title,
            text: text,
            icon: icon,
            background: '#1a1a1a',
            color: '#f8f9fa',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
        });
    }

    function sendToTechnician(applicationId) {
        const scheduleDate = document.getElementById('schedule_date_' + applicationId).value;
        const csrfToken = document.getElementById('csrf_token').value;

        if (!scheduleDate) {
            showSwal("Missing Date", "Please select a schedule date.", "warning");
            return;
        }

        fetch('http://localhost:8080/admin/sendToTechnician', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `application_id=${applicationId}&schedule_date=${scheduleDate}&csrf_test_name=${csrfToken}`
        })
        .then(async response => {
            const text = await response.text();
            try {
                const data = JSON.parse(text);
                showSwal(data.status === 'success' ? "Success" : "Error", data.message, data.status)
                    .then(() => {
                        if (data.status === 'success') location.reload();
                    });
            } catch (e) {
                console.error('Failed to parse JSON:', e, text);
                showSwal("Error", "Unexpected response from server.", "error");
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            showSwal("Error", "Something went wrong. Please try again.", "error");
        });
    }

    $(document).ready(function () {
        const csrfName = $('meta[name="csrf-token-name"]').attr('content');
        const csrfHash = $('meta[name="csrf-token-value"]').attr('content');

        $(".admit-btn").click(function () {
            let button = $(this);
            let appId = button.data("id");

            $.ajax({
                url: "<?= base_url('admin/admit') ?>",
                type: "POST",
                data: {
                    application_id: appId,
                    [csrfName]: csrfHash
                },
                dataType: "json",
                success: function (response) {
                    showSwal(
                        response.status === "success" ? "Admitted" : "Error",
                        response.message || "Application admitted successfully!",
                        response.status === "success" ? "success" : "error"
                    ).then(() => {
                        if (response.status === "success") location.reload();
                    });
                },
                error: function (xhr, status, error) {
                    showSwal("Error", "Error processing request: " + error, "error");
                }
            });
        });

        $(".decline-btn").click(function () {
            let appId = $(this).data("id");
            $("#decline_id").val(appId);
        });

        $("#confirmDecline").click(function () {
            let button = $(this);
            let appId = $("#decline_id").val();
            let reason = $("#reason").val().trim();

            if (!reason) {
                showSwal("Missing Reason", "Please provide a reason for declining.", "warning");
                return;
            }

            button.prop("disabled", true).find(".spinner-border").removeClass("d-none");

            $.ajax({
                url: "<?= base_url('admin/decline') ?>",
                type: "POST",
                data: {
                    application_id: appId,
                    reason: reason,
                    [csrfName]: csrfHash
                },
                dataType: "json",
                success: function (response) {
                    showSwal(
                        response.status === "success" ? "Declined" : "Error",
                        response.message || "Application declined successfully!",
                        response.status === "success" ? "success" : "error"
                    ).then(() => {
                        if (response.status === "success") location.reload();
                    });
                },
                error: function (xhr, status, error) {
                    showSwal("Error", "Error processing request: " + error, "error");
                },
                complete: function () {
                    button.prop("disabled", false).find(".spinner-border").addClass("d-none");
                }
            });
        });
    });
</script>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
