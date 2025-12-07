<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Campus Maintenance & Issue Reporting System</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap-icons.css">

  <style>
    /* Minimal Custom CSS: Only gradients, animation, and toast pos (irreplaceable by Bootstrap) */
    .navbar-gradient {
      background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
    }

    .hero-icon {
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-20px);
      }
    }

    .feature-card-hover {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card-hover:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15) !important;
    }

    /* Toast Positioning - Top-right popup banner */
    .toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1090;
    }
  </style>
</head>

<body class="bg-light">
  <!-- Navbar (Uses bg-primary as fallback; custom gradient applied) -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-gradient shadow-lg py-3">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-3" href="landing.php">
        <div class="bg-white rounded-3 p-2 shadow-sm" style="width: 48px; height: 48px;">
          <i class="bi bi-tools text-primary fs-3 d-flex align-items-center justify-content-center"></i>
        </div>
        <div>
          <div class="fw-bold fs-5">Campus Maintenance</div>
          <small class="text-white-50">Issue Reporting System</small>
        </div>
      </a>

      <div class="d-flex gap-2">
        <a href="index.php?action=showLogin" class="btn btn-light rounded-pill px-4 fw-semibold">
          <i class="bi bi-box-arrow-in-right me-2"></i>Admin Login
        </a>
      </div>
    </div>
  </nav>

  <!-- Error Alert Messages (Static, auto-dismissed by alerts.js) -->
  <div class="container mt-4">
    <?php if (isset($_SESSION['errors'])): ?>
      <div class="alert alert-danger alert-dismissible fade show border-0 shadow border-start border-danger border-5 bg-white" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Error:</strong>
        <ul class="mb-0 mt-2">
          <?php foreach ($_SESSION['errors'] as $error): ?>
            <li><?php echo $error; ?></li>
          <?php endforeach; ?>
        </ul>
        <?php unset($_SESSION['errors']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
  </div>

  <!-- Success Popup Banner (Bootstrap Toast) -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="toast-container">
      <div class="toast align-items-center text-white bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="d-flex">
          <div class="toast-body d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill fs-4"></i>
            <strong><?php echo htmlspecialchars($_SESSION['success']); ?></strong>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
    <?php unset($_SESSION['success']); // Clear after outputting 
    ?>
  <?php endif; ?>

  <!-- Hero Section (Bootstrap: fs-display-4, text-center, py-5) -->
  <div class="py-5 text-center">
    <div class="container">
      <div class="hero-icon mb-4 text-primary" style="font-size: 5rem; color: #1e40af;"> <!-- Minimal inline for color fallback -->
        <i class="bi bi-tools"></i>
      </div>

      <h1 class="display-4 fw-bold text-dark mb-4">
        Campus Maintenance & Issue Reporting System
      </h1>

      <div class="card shadow border-0 rounded-4 mx-auto mb-5" style="max-width: 800px;">
        <div class="card-body p-4 border-start border-primary border-5">
          <blockquote class="mb-0">
            <p class="fs-4 text-muted fst-italic mb-3">
              "A well-maintained campus is the foundation of a thriving learning environment.
              Together, we build excellence one report at a time."
            </p>
            <footer class="text-end text-primary fw-semibold">
              — Your Campus Maintenance Team
            </footer>
          </blockquote>
        </div>
      </div>

      <a href="landing.php?action=publicCreate" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg fw-bold">
        <i class="bi bi-plus-circle me-2"></i>Report an Issue
      </a>
    </div>
  </div>

  <!-- Features Section (Bootstrap: row g-4, card shadow-sm rounded-4) -->
  <div class="container pb-5">
    <h2 class="text-center fw-bold mb-5 text-dark">Why Report Issues?</h2>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="card feature-card-hover shadow-sm border-0 rounded-4 h-100"> <!-- Custom hover class applied -->
          <div class="card-body text-center p-4">
            <div class="text-primary mb-3 fs-1"> <!-- Bootstrap fs-1 for ~3rem size -->
              <i class="bi bi-lightning-charge-fill"></i>
            </div>
            <h4 class="fw-bold mb-3">Fast Response</h4>
            <p class="text-muted">
              Your reports are immediately sent to our maintenance team for quick action and resolution.
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card feature-card-hover shadow-sm border-0 rounded-4 h-100">
          <div class="card-body text-center p-4">
            <div class="text-primary mb-3 fs-1">
              <i class="bi bi-shield-check"></i>
            </div>
            <h4 class="fw-bold mb-3">Safe Campus</h4>
            <p class="text-muted">
              Help us maintain a safe and functional environment for everyone on campus.
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card feature-card-hover shadow-sm border-0 rounded-4 h-100">
          <div class="card-body text-center p-4">
            <div class="text-primary mb-3 fs-1">
              <i class="bi bi-people-fill"></i>
            </div>
            <h4 class="fw-bold mb-3">Community Effort</h4>
            <p class="text-muted">
              Every report matters. Be part of the solution and contribute to campus improvement.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer (Bootstrap: bg-dark, text-white) -->
  <footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
      <p class="mb-0">
        <i class="bi bi-tools me-2"></i>
        Campus Maintenance & Issue Reporting System © 2025
      </p>
      <small class="text-white-50">Making our campus better, one report at a time</small>
    </div>
  </footer>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="js/alerts.js"></script> <!-- Handles alert auto-dismiss + optional Toast init -->
</body>

</html>