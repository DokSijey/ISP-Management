<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel Login</title>
      <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    /* Scrollbar */
    ::-webkit-scrollbar { width: 10px; height: 10px; }
    ::-webkit-scrollbar-track { background: white; border-radius: 10px; }
    ::-webkit-scrollbar-thumb {
      background-color: #ff4d4f;
      border-radius: 10px;
      border: 2px solid #ff4d4f;
    }
    ::-webkit-scrollbar-thumb:hover { background-color: #ff4d4f; }

    body {
      background-color: #111315;
      color: #f8f9fa;
      font-family: 'Inter', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    ul, li {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .login-container {
      background-color: #1a1c1e;
      padding: 2.5rem;
      border-radius: 12px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 0 15px rgba(255, 0, 0, 0.2);
      border: 1px solid #2c2f31;
      position: relative;
    }

    .logo img {
      max-width: 80px;
      margin-bottom: 1rem;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    h2 {
      color: #ff4d4f;
      text-align: center;
      margin-bottom: 0.5rem;
    }

    p {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #ccc;
    }

    .form-label {
      color: #ff7875;
      font-weight: 500;
    }

    .custom-select-wrapper {
      position: relative;
      margin-bottom: 1rem;
    }

    .custom-select {
      background-color: #111315;
      color: #f8f9fa;
      padding: 0.5rem 2.5rem 0.5rem 0.75rem;
      border: 1px solid #2c2f31;
      border-radius: 6px;
      cursor: pointer;
      position: relative;
    }

    .custom-select::after {
      content: "\f078";
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #ff4d4f;
      pointer-events: none;
    }

    .custom-options {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background-color: #1a1c1f;
      border: 1px solid #ff4d4f;
      border-radius: 6px;
      z-index: 1000;
      margin-top: 5px;
      max-height: 180px;
      overflow-y: auto;
    }

    .custom-options.show {
      display: block;
    }

    .custom-options li {
      padding: 10px;
      color: #f8f9fa;
      cursor: pointer;
    }

    .custom-options li:hover,
    .custom-options li.active {
      background-color: #ff4d4f;
      color: #fff;
    }

    .form-control {
      background-color: #111315;
      color: #f8f9fa;
      border: 1px solid #2c2f31;
    }

    .form-control:focus {
      border-color: #ff4d4f;
      box-shadow: 0 0 0 0.2rem rgba(255, 77, 79, 0.35);
    }

    .btn-login {
      background-color: #ff4d4f;
      color: #fff;
      border: none;
      width: 100%;
      font-weight: 600;
      transition: background-color 0.2s;
    }

    .btn-login:hover {
      background-color: #ff7875;
    }

    .alert-danger {
      background-color: #ff4d4f;
      border: none;
      color: #fff;
    }
  </style>
</head>
<body>

<div class="login-container">
  <div class="logo">
    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Admin Logo">
  </div>
  <h2>Admin Login</h2>
  <p>Sign in to your admin dashboard</p>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('admin/authenticate') ?>" method="post" id="adminLoginForm">
    <?= csrf_field() ?>

    <div class="mb-3">
      <label class="form-label">Select Area</label>
      <div class="custom-select-wrapper">
        <div class="custom-select" id="areaDisplay">Select an area</div>
        <ul class="custom-options" id="areaOptions">
          <li data-value="Hagonoy">Hagonoy</li>
          <li data-value="City of Malolos">Malolos</li>
          <li data-value="Paombong">Paombong</li>
          <li data-value="Bataan">Bataan</li>
          <li data-value="Pampanga">Pampanga</li>
        </ul>
        <input type="hidden" name="area" id="areaInput" required>
      </div>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
    </div>

    <button type="submit" class="btn btn-login mt-2">Login</button>
  </form>
</div>

<script>
  const areaDisplay = document.getElementById('areaDisplay');
  const areaOptions = document.getElementById('areaOptions');
  const areaInput = document.getElementById('areaInput');

  areaDisplay.addEventListener('click', () => {
    areaOptions.classList.toggle('show');
  });

  document.querySelectorAll('#areaOptions li').forEach(option => {
    option.addEventListener('click', () => {
      areaDisplay.textContent = option.textContent;
      areaInput.value = option.getAttribute('data-value');
      areaOptions.classList.remove('show');
    });
  });

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.custom-select-wrapper')) {
      areaOptions.classList.remove('show');
    }
  });
</script>

</body>
</html>
