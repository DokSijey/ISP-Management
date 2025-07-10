<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Linking Google fonts for icons -->
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0"
  />
  <style>
        /* Custom styles from sidebar.php */
    .custom-logs-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .custom-logs-table th,
    .custom-logs-table td {
        padding: 8px 12px;
        border: 1px solid #ccc;
        text-align: left;
    }

    .custom-logs-table thead {
        background-color: #343a40;
        color: #fff;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .details-cell {
        max-width: 400px;
        word-wrap: break-word;
    }

    .timestamp-cell {
        white-space: nowrap;
        color: #555;
    }

    .action-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        text-transform: uppercase;
        background-color:rgb(255, 238, 0);
        color: black;
        font-size: 12px;
    }

  /* Search input style */
  #logSearch {
      max-width: 300px;
      margin-left: auto;
      margin-right: auto;
      display: block;
      border-radius: 20px;
      border: 1px solid #ccc;
      padding: 8px 16px;
      font-size: 1rem;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
      transition: border-color 0.3s ease;
  }
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }
    body {
      min-height: 100vh;
      background: linear-gradient(#f1faff, #cbe4ff);
    }
    .sidebar {
      position: fixed;
      width: 270px;
      margin: 16px;
      border-radius: 16px;
      background:rgb(0, 0, 0);
      height: calc(100vh - 32px);
      transition: all 0.4s ease;
      overflow-y: auto;
      padding-left: 0px;
    }
    .sidebar.collapsed {
      width: 85px;
    }
    .sidebar .sidebar-header {
      display: flex;
      position: relative;
      padding: 25px 20px;
      align-items: center;
      justify-content: space-between;
    }
    .sidebar-header .header-logo img {
      width: 46px;
      height: 46px;
      display: block;
      object-fit: contain;
      border-radius: 50%;
    }
    .sidebar-header .toggler {
      height: 35px;
      width: 35px;
      color:rgb(45, 21, 21);
      border: none;
      cursor: pointer;
      display: flex;
      background: #fff;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      transition: 0.4s ease;
    }
    .sidebar-toggler {
      display: block;         /* keep it in the layout so JS can find it */
      width: 0;
      height: 0;
      opacity: 0;             /* invisible */
      pointer-events: none;   /* disables clicking */
      overflow: hidden;
      border: none;
      background: none;
    }
    .sidebar-header .sidebar-toggler {
      position: absolute;
      right: 20px;
    }
    .sidebar-header .menu-toggler {
      display: none;
    }
    .sidebar.collapsed .sidebar-header .toggler {
      transform: translate(-4px, 65px);
    }
    .sidebar-header .toggler:hover {
      background:rgb(251, 221, 221);
    }
    .sidebar-header .toggler span {
      font-size: 1.75rem;
      transition: 0.4s ease;
    }
    .sidebar.collapsed .sidebar-header .toggler span {
      transform: rotate(180deg);
    }
    .sidebar-nav {
     text-align: left;
    }
    .sidebar-nav .nav-list {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
    .sidebar-nav .nav-item {
      position: relative;
    }
    .sidebar-nav .nav-link,
    .sidebar-nav .submenu-button {
      color: #fff;
      display: flex;
      justify-content: flex-start; /* changed from space-between */
      align-items: center;
      white-space: nowrap;
      border-radius: 8px;

      text-decoration: none;
      padding-left: 0px; /* reduce left padding if needed */
      background: none;
      border: none;
      width: 100%;
      cursor: pointer;
      font-size: 1rem;
      transition: background-color 0.3s ease;
      padding: 5px;
    }
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .submenu-button:hover {
          color:rgb(255, 255, 255);
          background:rgb(235, 0, 0);
          transition: 0.3s ease;
        }
    .sidebar-nav .nav-link .nav-icon,
    .sidebar-nav .submenu-button .nav-icon {
      margin-right: 12px;
      font-size: 1.2rem;
      display: inline-flex;
      align-items: center;
    }
    .sidebar-nav .nav-label {
      flex-grow: 1;
      text-align: left;
    }
    .sidebar-nav .submenu {
      list-style: none;
      padding-left: 1.25rem;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
      background-color:rgb(151, 0, 0);
      border-radius: 0 0 8px 8px;
      margin-bottom: 8px;
    }
    .sidebar-nav .submenu.show {
      max-height: 500px; /* enough to show all submenu items */
    }
    .sidebar-nav .submenu a {
      display: block;
      padding: 8px 15px;
      text-decoration: none;
      color: #ddd;
      border-radius: 6px;
      font-size: 0.95rem;
      transition: background-color 0.3s ease;
    }
    .sidebar-nav .submenu a:hover {
      background-color:rgba(255, 0, 0, 0.6);
      color: #fff;
    }
     #date {
    font-size: 0.85rem;
    color: #666;
  }

  /* Slight margin below logo and between time/date */
  .header-logo {
    margin-bottom: 0.5rem;
  }

  #clock {
    font-weight: 700;
    font-size: 1.2rem;
  }
    /* Responsive media query for small screens */
    @media (max-width: 1024px) {
      .sidebar {
        height: 56px;
        margin: 13px;
        overflow-y: hidden;
        scrollbar-width: none;
        width: calc(100% - 26px);
        max-height: calc(100vh - 26px);
      }
      .sidebar.menu-active {
        overflow-y: auto;
      }
      .sidebar .sidebar-header {
        position: sticky;
        top: 0;
        z-index: 20;
        border-radius: 16px;
        background: #151a2d;
        padding: 8px 10px;
      }
      .sidebar-header .header-logo img {
        width: 40px;
        height: 40px;
      }
      .sidebar-header .sidebar-toggler,
      .sidebar-nav .nav-item:hover .nav-tooltip {
        display: none;
      }

      .sidebar-header .menu-toggler {
        display: flex;
        height: 30px;
        width: 30px;
      }
      .sidebar-header .menu-toggler span {
        font-size: 1.3rem;
      }
      .sidebar-nav {
        padding: 0 10px;
      }
      .sidebar-nav .nav-link,
      .sidebar-nav .submenu-button {
        gap: 10px;
        padding: 10px;
        font-size: 0.94rem;
      }
      .sidebar-nav .nav-link .nav-icon,
      .sidebar-nav .submenu-button .nav-icon {
        font-size: 1.37rem;
      }
    }
      .submenu-button .material-symbols-rounded.rotated {
    transform: rotate(180deg);
    transition: transform 0.3s ease;
  }
  </style>
</head>
<body>
  <aside class="sidebar">
    <!-- Sidebar header -->
    <header class="sidebar-header d-flex flex-column align-items-center py-2">
      <a href="<?= base_url('admin/dashboard') ?>" class="header-logo mb-2">
        <img src="/assets/images/Logo.png" alt="Allstar Tech Internet Services" />
      </a>
      <div class="sidebar-heading text-center py-2 text-light" style="font-weight: 500; font-size: 0.9rem; opacity: 0.85;">
        <strong><?= session()->get('area') ?> Admin</strong>
      </div>
      <div id="clock" class="fw-bold"></div>
      <div id="date" class="fw-bold mb-2"></div>
      <button class="toggler sidebar-toggler mb-1">
        <span class="material-symbols-rounded">chevron_left</span>
      </button>
      <button class="toggler menu-toggler">
        <span class="material-symbols-rounded">menu</span>
      </button>
    </header>
    <nav class="sidebar-nav">
      <ul class="nav-list primary-nav">
        <li class="nav-item">
          <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
            <span class="nav-icon material-symbols-rounded">dashboard</span>
            <span class="nav-label">Dashboard</span>
          </a>
        </li><hr>
        <!-- Manage Subscribers collapsible -->
        <li class="nav-item">
          <button class="submenu-button">
            <span><span class="nav-icon material-symbols-rounded">group</span> Manage Subscribers</span>
            <span class="material-symbols-rounded">expand_more</span>
          </button>
          <ul class="submenu">
            <li><a href="<?= base_url('admin/subscribers') ?>">Subscribers List</a></li>
          </ul>
        </li>
        <!-- Manage Applications collapsible -->
        <li class="nav-item">
          <button class="submenu-button">
            <span><span class="nav-icon material-symbols-rounded">file_present</span> Manage Applications</span>
            <span class="material-symbols-rounded">expand_more</span>
          </button>
          <ul class="submenu">
            <li><a href="<?= base_url('admin/applications') ?>">Application List and other tables</a></li>
          </ul>
        </li><hr>
        <!-- Technician collapsible -->
        <li class="nav-item">
          <button class="submenu-button">
            <span><span class="nav-icon material-symbols-rounded">build_circle</span> Technician</span>
            <span class="material-symbols-rounded">expand_more</span>
          </button>
          <ul class="submenu">
            <li><a href="<?= base_url('admin/tickets') ?>">Technician Install / Repair Tickets and Generating Repair</a></li>
          </ul>
        </li><hr>
         <li class="nav-item">
          <button class="submenu-button">
            <span><span class="nav-icon material-symbols-rounded">payments</span>Billings</span>
            <span class="material-symbols-rounded">expand_more</span>
          </button>
          <ul class="submenu">
            <li><a href="<?= base_url('admin/billings') ?>">Set Billing and Billing Status</a></li>
          </ul>
        </li><hr>
        <!-- Finance collapsible -->
        <li class="nav-item">
          <button class="submenu-button">
            <span><span class="nav-icon material-symbols-rounded">paid</span> Finance</span>
            <span class="material-symbols-rounded">expand_more</span>
          </button>
          <ul class="submenu">
            <li><a href="<?= base_url('admin/finance/finance-records') ?>">View Finance Records</a></li>
          </ul>
        </li><hr>
        <!-- Reports (no submenu) -->
        <li class="nav-item">
          <a href="#" id="generateReports" class="nav-link">
            <span class="nav-icon material-symbols-rounded">analytics</span>
            <span class="nav-label">Generate Reports</span>
          </a>
        </li>

        <!-- Logs (no submenu) -->
        <li class="nav-item">
          <a href="#" id="viewLogsBtn" class="nav-link">
            <span class="nav-icon material-symbols-rounded">history</span>
            <span class="nav-label">Logs</span>
          </a>
        </li><hr>
        <!-- Logout -->
        <li class="nav-item">
          <a href="<?= base_url('admin/logout') ?>" class="nav-link">
            <span class="nav-icon material-symbols-rounded">logout</span>
            <span class="nav-label">Logout</span>
          </a>
        </li>
      </ul>
    </nav>
  </aside>
  <!-- MAIN CONTENT (NAVBAR + PAGE CONTENT) -->
  <div class="flex-grow-1 d-flex flex-column" style="overflow-y: auto;">
    
  <script>
 const sidebar = document.querySelector(".sidebar");

  // Sidebar collapse toggle (left chevron)
  document.querySelector(".sidebar-toggler").addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
  });

  // Menu toggler for small screens (hamburger menu)
  document.querySelector(".menu-toggler").addEventListener("click", () => {
    sidebar.classList.toggle("menu-active");
  });

  // Submenu toggles (arrow rotates and submenu expands)
  document.querySelectorAll(".submenu-button").forEach(button => {
    const arrowIcon = button.querySelector(".material-symbols-rounded:last-child");

    button.addEventListener("click", () => {
      const submenu = button.nextElementSibling;
      submenu.classList.toggle("show");
      arrowIcon.classList.toggle("rotated");
    });
  });
  function updateDateTime() {
  const clock = document.getElementById('clock');
  const date = document.getElementById('date');

  if (!clock || !date) return;

  const now = new Date();

  // Format time: hh:mm:ss AM/PM
  let hours = now.getHours();
  const minutes = now.getMinutes().toString().padStart(2, '0');
  const seconds = now.getSeconds().toString().padStart(2, '0');
  const ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12 || 12; // Convert to 12-hour format

  const timeString = `${hours}:${minutes}:${seconds} ${ampm}`;
  clock.textContent = timeString;

  // Format date: Weekday, Month Day, Year
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const dateString = now.toLocaleDateString(undefined, options);
  date.textContent = dateString;
}

// Update every second
setInterval(updateDateTime, 1000);
updateDateTime(); // Initial call
  document.getElementById('viewLogsBtn').addEventListener('click', function (e) {
    e.preventDefault();

    fetch('<?= site_url('admin/fetch-logs') ?>')
    .then(response => response.json())
    .then(data => {
        if (!data || data.length === 0) {
            Swal.fire('No logs found.', '', 'info');
            return;
        }

        const formatTimestamp = (ts) => {
            const date = new Date(ts);
            return date.toLocaleString();
        };

        const escapeHtml = (text) => {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        };

        let html = `
            <style>
            .dark-log-container .table-responsive {
    max-height: 600px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #888 #000; /* thumb and track */
}

.dark-log-container .table-responsive::-webkit-scrollbar {
    width: 8px;
}

.dark-log-container .table-responsive::-webkit-scrollbar-track {
    background: #000;
}

.dark-log-container .table-responsive::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 4px;
}
                .dark-log-container {
                    color: white;
                    padding: 15px;
                    border-radius: 8px;
                }
                .dark-log-container input {
                    background-color: #222;
                    color: white;
                    border: 1px solid #555;
                    padding: 5px;
                    margin-bottom: 10px;
                    width: 100%;
                }
                .dark-log-container table {
                    width: 100%;
                    border-collapse: collapse;
                    color: white;
                    border-radius: 0 !important; /* Ensures no rounding */
                }
                .dark-log-container td {
                    border-top: 1px solid rgba(255, 255, 255, 0.12);   /* horizontal border only */
                    border-left: none;             /* remove vertical left border */
                    border-right: none;            /* remove vertical right border */
                    padding: 8px;
                    background-color: rgb(0, 0, 0);
                    color: white;
                    text-align: center;
                }

                .dark-log-container th {
                    border-bottom: 1px solid #000; /* or keep no borders, your choice */
                    background-color: rgb(250, 252, 255);
                    color: black;
                    padding: 10px;
                    position: sticky;
                    top: 0;
                }
                .action-badge {
                    background-color:rgb(0, 81, 255);
                    padding: 2px 6px;
                    border-radius: 4px;
                    color: white;
                    font-size: 12px;
                }
            </style>

            <div class="dark-log-container">
                <input type="text" id="logSearch" placeholder="Search logs...">
                <div class="table-responsive" style="max-height:600px; overflow-y:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Admin</th>
                                <th>Action</th>
                                <th>Details</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>`;

        data.forEach(log => {
            let detailsText = escapeHtml(log.details);
            const maxLength = 70;
            let displayDetails = detailsText.length > maxLength 
                ? `${detailsText.slice(0, maxLength)}&hellip;` 
                : detailsText;

            html += `
                <tr title="${detailsText}">
                    <td>${log.area}</td>
                    <td><span class="action-badge">${log.action}</span></td>
                    <td>${displayDetails}</td>
                    <td>${formatTimestamp(log.timestamp)}</td>
                </tr>`;
        });

        html += `
                        </tbody>
                    </table>
                </div>
            </div>`;

        Swal.fire({
            title: 'Action Logs',
            html: html,
            width: '85%',
            background: 'rgb(0, 0, 0)',
            color: '#fff',
            showCloseButton: true,
            confirmButtonText: 'Close',
            didOpen: () => {
                const input = Swal.getPopup().querySelector('#logSearch');
                const tableBody = Swal.getPopup().querySelector('tbody');

                input.addEventListener('input', () => {
                    const filter = input.value.toLowerCase();
                    Array.from(tableBody.rows).forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(filter) ? '' : 'none';
                    });
                });
            }
        });
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Error fetching logs.', '', 'error');
    });
});
document.addEventListener('DOMContentLoaded', function () {
  const reportLink = document.getElementById('generateReports');
  if (reportLink) {
    reportLink.addEventListener('click', function (e) {
      e.preventDefault(); // prevent page from reloading
      promptDownloadReport(); // call the function
    });
  }
});
$(document).ready(function () {
  $('#generateReports').click(function (e) {
    e.preventDefault();
    promptDownloadReport();
  });
});
function promptDownloadReport() {
    Swal.fire({
        title: 'Pick a Report',
        input: 'select',
        inputOptions: {
            'subscribers_report': 'Subscribers Report',
            'billing_report': 'Billing Report',
            'install_tickets': 'Install Tickets',
            'repair_tickets': 'Repair Tickets'
        },
        inputPlaceholder: 'Select a report to generate',
        showCancelButton: true,
        confirmButtonText: 'Generate and Download',
        cancelButtonText: 'Cancel',
        preConfirm: (selectedReport) => {
            console.log('Selected Report:', selectedReport); // Log the selected report
            if (!selectedReport) {
                Swal.showValidationMessage('Please select a report');
            }
            return selectedReport;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Report Generation Confirmed:', result.value); // Log confirmation result
            const report = result.value;
            Swal.fire('Generating report...', '', 'info');
            generateReport(report);
        }
    });
}

// This function can either generate the report on the front-end or call a PHP method via AJAX.
function generateReport(report) {
    console.log('Generating Report for:', report); // Log which report is being generated

    if (report === 'subscribers_report') {
        console.log('Redirecting to generate subscribers report...');
        window.location.href = '/admin/generate-subscribers-report';

    } else if (report === 'billing_report') {
        console.log('Redirecting to generate billing report...');
        window.location.href = '/admin/generate-billing-report';

    } else if (report === 'install_tickets' || report === 'repair_tickets') {
        // SweetAlert2 month input for both install and repair
        Swal.fire({
            title: 'Select Month',
            input: 'month',
            inputLabel: 'Choose the month to generate report for:',
            inputAttributes: {
                min: '2024-01',
                max: '2025-12'
            },
            showCancelButton: true,
            confirmButtonText: 'Generate',
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                const selectedMonth = result.value; // Format: YYYY-MM
                console.log('Selected Month:', selectedMonth); // Log the selected month

                if (report === 'install_tickets') {
                    console.log('Redirecting to generate install tickets report for month:', selectedMonth);
                    window.location.href = '/admin/generate-install-tickets-report?month=' + encodeURIComponent(selectedMonth);
                } else if (report === 'repair_tickets') {
                    console.log('Redirecting to generate repair tickets report for month:', selectedMonth);
                    window.location.href = '/admin/generate-repair-tickets-report?month=' + encodeURIComponent(selectedMonth);
                }
            }
        });
    }
}
  </script>
</body>
</html>
