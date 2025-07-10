<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">

  <title>Technician Login</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome (optional if you use icons later) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #0d1117;
      color: #f1f5f9;
      font-family: 'Inter', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 20px;
    }

    .login-box {
      background-color: #1f2937;
      padding: 2.5rem;
      border-radius: 12px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 0 15px rgba(37, 99, 235, 0.2);
      border: 1px solid #334155;
    }

    .login-box h2 {
      text-align: center;
      color: #3b82f6;
      margin-bottom: 1rem;
    }

    .login-box p {
      text-align: center;
      color: #94a3b8;
      margin-bottom: 2rem;
    }

    .form-label {
      color: #93c5fd;
    }

    .form-control {
      background-color: #0d1117;
      color: #f8fafc;
      border: 1px solid #334155;
    }

    .form-control:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.35);
    }

    .btn-primary {
      background-color: #2563eb;
      border: none;
      font-weight: 600;
    }

    .btn-primary:hover {
      background-color: #3b82f6;
    }

    .alert-danger {
      background-color: #ef4444;
      border: none;
      color: #fff;
    }

    .logo {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .logo img {
      max-width: 80px;
    }
  </style>
</head>
<body>

<div class="login-box">
  <div class="logo">
    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Technician Logo">
  </div>
  <h2>Technician Login</h2>
  <p>Enter your credentials to continue</p>

  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <form action="<?= base_url('technician/authenticate') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
      <label for="name" class="form-label">Technician Name:</label>
      <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password:</label>
      <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
  </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
