<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report New Issue - Campus Maintenance</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap-icons.css">

  <style>
    /* Minimal Css internal only, if bootstrap can't handle */
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      position: relative;
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

    /* Toast positioning for public create page */
    .toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1090;
    }
  </style>
</head>

<body class="min-vh-100">
  <!-- Toast Container -->
  <div class="toast-container">
    <!-- Error Toast (for validation errors) -->
    <?php if (isset($_SESSION['errors'])): ?>
      <div class="toast align-items-center text-white bg-danger border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="d-flex">
          <div class="toast-body">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Validation Errors:</strong>
            <ul class="mb-0 mt-2">
              <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
      <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
  </div>

  <div class="content-wrapper">
    <!-- Public Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-gradient shadow-lg py-3">
      <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center gap-3 text-decoration-none" href="landing.php">
          <div class="bg-white rounded-3 p-2 shadow-sm" style="width: 48px; height: 48px;">
            <i class="bi bi-tools text-primary fs-3 d-flex align-items-center justify-content-center"></i>
          </div>

          <div class="d-none d-lg-block">
            <div class="fw-bold fs-4 lh-1 mb-1" style="letter-spacing: -0.5px;">
              Campus Maintenance & Issue Reporting
            </div>
            <small class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 1.5px;">
              Comprehensive Campus Management System
            </small>
          </div>

          <div class="d-lg-none">
            <div class="fw-bold fs-5">Campus Maintenance</div>
          </div>
        </a>

        <div class="d-flex align-items-center gap-2 gap-md-3">
          <div class="d-none d-md-flex align-items-center gap-2 text-white bg-white bg-opacity-10 rounded-pill px-3 py-2">
            <i class="bi bi-plus-circle"></i>
            <span class="fw-semibold small">Report New Issue</span>
          </div>

          <div class="vr bg-white opacity-25 d-none d-md-block" style="height: 30px;"></div>

          <a href="index.php?action=showLogin" class="btn btn-light rounded-pill px-3 px-md-4 fw-semibold">
            <i class="bi bi-box-arrow-in-right me-1"></i>
            <span class="d-none d-sm-inline">Admin Login</span>
          </a>

          <a href="landing.php" class="btn btn-outline-light fw-semibold rounded-pill px-3 px-md-4">
            <i class="bi bi-arrow-left me-1"></i>
            <span class="d-none d-sm-inline">Back</span>
          </a>
        </div>
      </div>
    </nav>

    <div class="container mt-4 mb-5">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card shadow border-0 rounded-4 bg-white">
            <div class="card-header bg-primary text-white border-0 p-4 rounded-top-4">
              <h4 class="mb-1 fw-bold">
                <i class="bi bi-plus-circle me-2"></i>Report New Maintenance Issue
              </h4>
              <p class="mb-0 opacity-90">Fill out the form below to submit a maintenance request</p>
            </div>
            <div class="card-body p-4 p-md-5">
              <?php
              // Set variables for form partial
              $action = 'landing.php?action=publicStore';
              $method = 'POST';
              $isEdit = false;
              // Include the reusable form partial
              require_once __DIR__ . '/../issues/partials/form.php';
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="js/validation.js"></script>
  <script src="js/preview.js"></script>
  <script src="js/alerts.js"></script>

</body>

</html>