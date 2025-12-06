<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Issue #<?php echo $issue['id']; ?> - Campus Maintenance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

  <style>
    /* Minimal CSS - Only what Bootstrap can't do */
    body {
      background: linear-gradient(to bottom, #e0e7ff 0%, #f3f4f6 100%);
    }

    .navbar-gradient {
      background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
    }
  </style>
</head>

<body class="min-vh-100">
  <!-- Enhanced Professional Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-gradient shadow-lg py-3">
    <div class="container-fluid px-4">
      <!-- Brand Section with Logo -->
      <a class="navbar-brand d-flex align-items-center gap-3 text-decoration-none" href="index.php">
        <!-- Logo Badge -->
        <div class="bg-white rounded-3 p-2 shadow-sm" style="width: 48px; height: 48px;">
          <i class="bi bi-tools text-primary fs-3 d-flex align-items-center justify-content-center"></i>
        </div>

        <!-- Brand Text -->
        <div class="d-none d-lg-block">
          <div class="fw-bold fs-4 lh-1 mb-1" style="letter-spacing: -0.5px;">
            Campus Maintenance & Issue Reporting
          </div>
          <small class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 1.5px;">
            Comprehensive Campus Management System
          </small>
        </div>

        <!-- Compact for smaller screens -->
        <div class="d-lg-none">
          <div class="fw-bold fs-5">Campus Maintenance</div>
        </div>
      </a>

      <!-- Replace the "Right Side Actions" section with: -->
      <div class="d-flex align-items-center gap-2 gap-md-3">
        <div class="d-none d-md-flex align-items-center gap-2 text-white bg-white bg-opacity-10 rounded-pill px-3 py-2">
          <i class="bi bi-pencil-square"></i>
          <span class="fw-semibold small">Edit Issue #<?php echo $issue['id']; ?></span>
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

        <a href="index.php?action=show&id=<?php echo $issue['id']; ?>" class="btn btn-secondary fw-semibold rounded-pill px-3 px-md-4 shadow-sm">
          <i class="bi bi-arrow-left me-1"></i>
          <span class="d-none d-sm-inline">Back to Details</span>
          <span class="d-sm-none">Back</span>
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
          <div class="card-header bg-warning text-dark border-0 p-4 rounded-top-4">
            <h4 class="mb-1 fw-bold">
              <i class="bi bi-pencil-square me-2"></i>Edit Issue #<?php echo $issue['id']; ?>
            </h4>
            <p class="mb-0">Update the issue information below</p>
          </div>
          <div class="card-body p-4 p-md-5">
            <?php
            $action = 'index.php?action=update';
            $method = 'POST';
            $isEdit = true;
            require_once __DIR__ . '/partials/form.php';
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JavaScript Files -->
  <script src="js/validation.js"></script>
  <script src="js/preview.js"></script>
  <script src="js/alerts.js"></script>

</body>

</html>