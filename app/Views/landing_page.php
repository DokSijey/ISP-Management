<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Allstar Tech Hotspot Wireless Internet Services</title>
    <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .dropdown-submenu {
  position: relative;
}
.dropdown-submenu > .dropdown-menu {
  top: 0;
  left: 100%;
  margin-left: 0.1rem;
  margin-right: 0.1rem;
}
</style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Logo" height="70" class="me-2">
            <span class="brand-name fs-1">ALLSTAR TECH INTERNET</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- Top Section -->
 <div class="top-section">
    <div class="container text-center text-white mt-5 pt-5">
        <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Logo" height="200">
        <h1>Fast & Reliable Internet</h1>
        <p>Experience high-speed internet with Allstar Tech.</p>
        <a href="/application-form" class="btn btn-danger btn-lg mt-3">Apply Now →</a>
    </div>
</div>

<!-- New Feature Section -->
 <section class="feature-section">
    <div class="container">
        <h2>We've got you covered with reliable internet that’s right for your home.</h2>
            <div class="row">
                <div class="col-md-4 feature-item">
                    <i class="bi bi-clock-history"></i>
                    <h5>Be more productive than ever</h5>
                    <p>With faster speeds that Allstar Tech can provide.</p>
                </div>
                <div class="col-md-4 feature-item">
                    <i class="bi bi-play-circle"></i>
                    <h5>There's no limit!</h5>
                    <p>Stream and browse without interruption.</p>
                </div>
                <div class="col-md-4 feature-item">
                    <i class="bi bi-wifi"></i>
                    <h5>Stay connected</h5>
                    <p>Enjoy seamless connectivity with our premium plans.</p>
                </div>
            </div>
    </div>
</section>

<!-- Plans Section -->
<section id="plansSection" style="background: #121212; padding: 4rem 0;">
  <div class="container" style="max-width: 1200px; margin: 0 auto;">
    <h2 style="
      color: #fff; 
      font-weight: 800; 
      font-size: 2.5rem; 
      text-align: center; 
      margin-bottom: 3rem;
      letter-spacing: 2px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    ">Choose Your Internet Plan</h2>

    <div class="row g-4 justify-content-center">
      <?php foreach ($plans as $plan): ?>
      <div class="col-lg-3 col-md-6 col-sm-12 d-flex">
        <div style="
          background: radial-gradient(circle at top left, #2a0000, #1a1a1a);
          border-radius: 16px;
          padding: 2rem 1.5rem;
          width: 100%;
          box-shadow: 0 4px 12px rgba(255, 59, 59, 0.25);
          color: #eee;
          display: flex;
          flex-direction: column;
          align-items: center;
          position: relative;
          transition: transform 0.4s cubic-bezier(.4,0,.2,1), box-shadow 0.4s ease;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          cursor: pointer;
        " 
          onmouseover="this.style.transform='translateY(-8px) scale(1.05)'; this.style.boxShadow='0 12px 30px rgba(255, 59, 59, 0.6)';" 
          onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 12px rgba(255, 59, 59, 0.25)';"
        >
          <?php if (isset($plan['best_seller'])): ?>
          <span style="
            position: absolute;
            top: 18px;
            right: 18px;
            background: linear-gradient(135deg, #ff4747, #ff1a1a);
            color: #fff;
            padding: 5px 14px;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 30px;
            letter-spacing: 0.05em;
            box-shadow: 0 0 8px #ff2a2a;
            user-select: none;
          ">BEST SELLER</span>
          <?php endif; ?>

          <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Plan Logo" height="48" style="margin-bottom: 1.2rem; filter: none;">

          <h3 style="
            font-size: 2.2rem; 
            font-weight: 900; 
            color: #ff3b3b; 
            margin: 0 0 0.6rem;
            letter-spacing: 1.2px;
          ">
            <?= $plan['speed'] ?>
          </h3>

          <p style="
            font-weight: 700; 
            font-size: 1.3rem; 
            margin: 0 0 1rem;
            color: #fff;
          "><?= $plan['price'] ?></p>

          <p style="
            font-size: 1rem;
            color: #aaa;
            font-weight: 500;
            margin-bottom: 2rem;
            text-align: center;
            line-height: 1.4;
          "><?= $plan['description'] ?></p>

          <a href="<?= base_url('/application-form?plan=') . urlencode($plan['speed'] . ' - ' . $plan['price']) ?>" style="width: 100%;">
            <button style="
              background: #ff3b3b;
              border: none;
              border-radius: 10px;
              padding: 12px 0;
              color: white;
              font-weight: 800;
              font-size: 1.1rem;
              width: 100%;
              letter-spacing: 1px;
              box-shadow: 0 4px 15px rgba(255, 59, 59, 0.6);
              transition: background 0.3s ease, box-shadow 0.3s ease;
            " 
              onmouseover="this.style.background='#e63232'; this.style.boxShadow='0 6px 20px rgba(230, 50, 50, 0.85)';" 
              onmouseout="this.style.background='#ff3b3b'; this.style.boxShadow='0 4px 15px rgba(255, 59, 59, 0.6)';"
            >Avail Plan</button>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- FIBER Feature Section -->
<section class="feature-section">
        <div class="container">
            <h2>SUPER RELIABLE  <span class="feature">FIBER INTERNET</span></h2>
            <div class="row">
                <div class="col-md-3 feature-item">
                    <i class="bi bi-gear"></i>
                    <h5>No Lock-in Period <br>No Termination Fee</h5>
                </div>
                <div class="col-md-3 feature-item">
                    <i class="bi bi-tools"></i>
                    <h5>Fast Repair</h5>
                    
                </div>
                <div class="col-md-3 feature-item">
                    <i class="bi bi-headset"></i>
                    <h5>Friendly Customer <br>Service Support</h5>
                </div>
                <div class="col-md-3 feature-item">
                    <i class="bi bi-shield-check"></i>
                    <h4 style="text-transform: uppercase;"><b>1 Valid ID Only!</b></h4>
                </div>
            </div>
        </div>
    </section>

<!-- Available Locations Section -->
<section id="locationSection" style="background: linear-gradient(135deg, #f2f4f8, #e9f0ff); padding: 4rem 1rem;">
  <div style="max-width: 1200px; margin: auto;">
    <h2 style="text-align: center; color: #2c3e50; font-size: 2.8rem; font-weight: 800; margin-bottom: 2rem;">
      📍 We're Available In These Areas!
    </h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
      <!-- Malolos -->
      <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: 0.3s;">
        <h3 style="color: #1e88e5; font-weight: 700; margin-bottom: 1rem;">Malolos</h3>
        <p style="color: #333; font-size: 0.95rem; line-height: 1.6;">
          Sto. Rosario, Sumapang Bata, Sumapang Matanda, Ligas, Dakila, Bungahan, Maunlad, Mojon, Menzyland, San Juan, Cofradia, Bulihan, Mabolo
        </p>
      </div>

      <!-- Hagonoy -->
      <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
        <h3 style="color: #1e88e5; font-weight: 700; margin-bottom: 1rem;">Hagonoy</h3>
        <p style="color: #333;">All barangays covered!</p>
      </div>

      <!-- Paombong -->
      <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
        <h3 style="color: #1e88e5; font-weight: 700; margin-bottom: 1rem;">Paombong</h3>
        <p style="color: #333;">We're available in select areas.</p>
      </div>

      <!-- Nueva Ecija -->
      <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
        <h3 style="color: #1e88e5; font-weight: 700; margin-bottom: 1rem;">Nueva Ecija</h3>
        <p style="color: #333;">Cabanatuan and Cabiao areas are covered.</p>
      </div>

      <!-- Bataan -->
      <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
        <h3 style="color: #1e88e5; font-weight: 700; margin-bottom: 1rem;">Bataan</h3>
        <p style="color: #333;">We currently serve Mariveles and Balanga.</p>
      </div>
    </div>
    <!-- CTA -->
    <div style="text-align: center; margin-top: 3rem;">
      <a href="#plansSection" style="display: inline-block; background-color: #e53935; color: white; padding: 0.75rem 2rem; border-radius: 50px; font-weight: bold; font-size: 1.1rem; text-decoration: none; box-shadow: 0 5px 15px rgba(229, 57, 53, 0.4); transition: 0.3s;">
        Check Internet Plans in Your Area →
      </a>
    </div>
  </div>
</section>


<!-- MAP Section -->
<section class="map-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Column - Map Image -->
            <div class="col-lg-6 text-center">
                <img src="<?= base_url('assets/images/map.png') ?>" alt="Service Coverage Map" class="img-fluid rounded shadow">          
                <a href="https://maps.app.goo.gl/YsDHu6y8CMWr3nHX8" class="btn btn-danger mt-3" target="_blank" rel="noopener noreferrer">View Full Coverage</a>
            </div>

            <!-- Right Column - Information -->
            <div class="col-lg-6">
                <h2 class="fw-bold">Our Main Office</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="bi bi-geo-alt-fill text-danger"></i> Main Office: Purok 6, Sitio Pulo, Sumapang Bata, Malolos, 3000 Bulacan</li>
                    <li class="list-group-item"><i class="bi bi-telephone-fill text-danger"></i> Contact Us: +63 917 105 0406</li>
                    <li class="list-group-item"><i class="bi bi-envelope-fill text-danger"></i> Email: allstartechinternetservices@gmail.com</li>
                    <li class="list-group-item"><i class="bi bi-facebook text-danger"></i> Facebook Page: <a href='https://www.facebook.com/Allstartechmaloloscity'>Allstar Tech Malolos City</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>


    <?= view('footer') ?>
</body>
<script>
// JS for handling nested dropdown toggle (Bootstrap 5)
document.querySelectorAll('.dropdown-submenu > a').forEach(element => {
  element.addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();

    const submenu = this.nextElementSibling;
    if (!submenu.classList.contains('show')) {
      // Hide any other open submenus
      this.closest('.dropdown-menu').querySelectorAll('.dropdown-menu.show').forEach(openSubmenu => {
        openSubmenu.classList.remove('show');
      });
    }
    submenu.classList.toggle('show');
  });
});

    </script>
</html>
