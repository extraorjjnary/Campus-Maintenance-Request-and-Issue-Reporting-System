<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report New Issue - Campus Maintenance</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap-icons.css">

  <style>
    /* Minimal css internal only, if bootstrap can't handle */
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
  </style>
</head>

<body class="min-vh-100">
  <div class="content-wrapper">
    <!-- Enhanced Professional Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-gradient shadow-lg py-3">
      <div class="container-fluid px-4">
        <!-- Brand Section with Logo -->
        <a class="navbar-brand d-flex align-items-center gap-3 text-decoration-none" href="index.php">
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

          <div class="dropdown">
            <button class="btn btn-light rounded-pill px-3 fw-semibold dropdown-toggle"
              type="button"
              id="adminDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="bi bi-person-circle me-1"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="adminDropdown">
              <li>
                <span class="dropdown-item-text">
                  <i class="bi bi-shield-check me-2 text-primary"></i>
                  <strong><?php echo isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin'; ?></strong>
                </span>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item text-danger" href="index.php?action=logout">
                  <i class="bi bi-box-arrow-right me-2"></i>Logout
                </a>
              </li>
            </ul>
          </div>

          <a href="index.php" class="btn btn-secondary fw-semibold rounded-pill px-3 px-md-4 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i>
            <span class="d-none d-sm-inline">Dashboard</span>
          </a>
        </div>
      </div>
    </nav>

    <div class="container mt-4 mb-5">
      <!-- Alert Messages -->
      <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow border-start border-danger border-5 bg-white" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Validation Errors:</strong>
          <ul class="mb-0 mt-2">
            <?php foreach ($_SESSION['errors'] as $error): ?>
              <li><?php echo $error; ?></li>
            <?php endforeach; ?>
          </ul>
          <?php unset($_SESSION['errors']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

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
              $action = 'index.php?action=store';
              $method = 'POST';
              $isEdit = false;
              // Include the reusable form partial
              require_once __DIR__ . '/partials/form.php';
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>


  <!-- Custom JavaScript Files -->
  <script src="js/validation.js"></script>
  <script src="js/preview.js"></script>
  <script src="js/alerts.js"></script>

</body>

</html>