<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Campus Maintenance & Issue Reporting System</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap-icons.css">

  <style>
    /* Minimal custom CSS: Gradients, animations, and essential overrides only */
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      position: relative;
      overflow-x: hidden;
    }

    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image:
        radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
      pointer-events: none;
      z-index: 0;
    }

    .content-wrapper {
      position: relative;
      z-index: 1;
    }

    .navbar-gradient {
      background: rgba(90, 103, 216, 0.95) !important;
      backdrop-filter: blur(10px);
    }

    .hero-icon {
      font-size: 5rem;
      color: #1e3a8a !important;
      /* Dark blue for high contrast on gradient */
      animation: float 3s ease-in-out infinite;
      filter: drop-shadow(0 10px 20px rgba(30, 58, 138, 0.6));
      /* Stronger shadow for visibility */
      display: inline-block;
      /* Simple display for icon only */
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

    .hero-section {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 30px;
      backdrop-filter: blur(10px);
    }

    .feature-card {
      background: rgba(255, 255, 255, 0.95);
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
      border-color: #667eea;
    }

    .feature-icon-wrapper {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      width: 80px;
      height: 80px;
      border-radius: 50%;
      display: flex !important;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .feature-icon-wrapper i {
      color: white !important;
      font-size: 2.5rem;
    }

    .quote-card {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
      border-left: 5px solid #667eea;
    }

    .cta-button {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
      transition: all 0.3s ease;
    }

    .cta-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
    }

    .section-title {
      color: white;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    /* Floating shapes (minimal) */
    .shape {
      position: fixed;
      border-radius: 50%;
      opacity: 0.1;
      pointer-events: none;
      z-index: 0;
    }

    .shape-1 {
      width: 300px;
      height: 300px;
      background: white;
      top: -100px;
      right: -100px;
    }

    .shape-2 {
      width: 200px;
      height: 200px;
      background: white;
      bottom: -50px;
      left: -50px;
    }

    /* Toast container */
    .toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1090;
    }
  </style>
</head>

<body>
  <!-- Decorative shapes -->
  <div class="shape shape-1"></div>
  <div class="shape shape-2"></div>

  <div class="content-wrapper">
    <!-- Navbar -->
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
          <a href="index.php?action=showLogin" class="btn btn-light rounded-pill px-4 fw-semibold shadow-sm">
            <i class="bi bi-box-arrow-in-right me-2"></i>Admin Login
          </a>
        </div>
      </div>
    </nav>

    <!-- Toast Container -->
    <div class="toast-container">
      <!-- Success Toast -->
      <?php if (isset($_SESSION['success'])): ?>
        <div class="toast align-items-center text-white bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
          <div class="d-flex">
            <div class="toast-body">
              <i class="bi bi-check-circle-fill me-2"></i>
              <strong><?php echo htmlspecialchars($_SESSION['success']);
                      unset($_SESSION['success']); ?></strong>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      <?php endif; ?>

      <!-- Error Toast -->
      <?php if (isset($_SESSION['errors'])): ?>
        <div class="toast align-items-center text-white bg-danger border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
          <div class="d-flex">
            <div class="toast-body">
              <i class="bi bi-exclamation-triangle-fill me-2"></i>
              <strong>Error:</strong>
              <ul class="mb-0 mt-2">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                  <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Hero Section -->
    <div class="container my-5">
      <div class="hero-section shadow-lg p-5 text-center rounded-5">
        <div class="hero-icon mb-4">
          <i class="bi bi-tools"></i>
        </div>

        <h1 class="display-4 fw-bold mb-4 text-primary">
          Campus Maintenance & Issue Reporting System
        </h1>

        <div class="quote-card rounded-4 p-4 mb-5 mx-auto" style="max-width: 800px;">
          <blockquote class="mb-0">
            <p class="fs-5 fst-italic mb-3 text-secondary">
              "A well-maintained campus is the foundation of a thriving learning environment.
              Together, we build excellence one report at a time."
            </p>
            <footer class="text-end fw-semibold text-primary">
              — Your Campus Maintenance Team
            </footer>
          </blockquote>
        </div>

        <a href="landing.php?action=publicCreate" class="btn btn-primary cta-button btn-lg rounded-pill px-5 py-3 fw-bold">
          <i class="bi bi-plus-circle me-2"></i>Report an Issue
        </a>
      </div>
    </div>

    <!-- Features Section -->
    <div class="container pb-5">
      <h2 class="text-center fw-bold mb-5 section-title">Why Report Issues?</h2>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="card feature-card border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body text-center p-4">
              <div class="feature-icon-wrapper mb-4">
                <i class="bi bi-lightning-charge-fill"></i>
              </div>
              <h4 class="fw-bold mb-3 text-primary">Fast Response</h4>
              <p class="text-muted">
                Your reports are immediately sent to our maintenance team for quick action and resolution.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card feature-card border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body text-center p-4">
              <div class="feature-icon-wrapper mb-4">
                <i class="bi bi-shield-check"></i>
              </div>
              <h4 class="fw-bold mb-3 text-primary">Safe Campus</h4>
              <p class="text-muted">
                Help us maintain a safe and functional environment for everyone on campus.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card feature-card border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body text-center p-4">
              <div class="feature-icon-wrapper mb-4">
                <i class="bi bi-people-fill"></i>
              </div>
              <h4 class="fw-bold mb-3 text-primary">Community Effort</h4>
              <p class="text-muted">
                Every report matters. Be part of the solution and contribute to campus improvement.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
      <div class="container text-center">
        <p class="mb-0">
          <i class="bi bi-tools me-2"></i>
          Campus Maintenance & Issue Reporting System © 2025
        </p>
        <small class="text-white-50">Making our campus better, one report at a time</small>
      </div>
    </footer>
  </div>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="js/alerts.js"></script>

</body>

</html>