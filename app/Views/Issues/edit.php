<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Issue #<?php echo $issue['id']; ?> - Campus Maintenance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

  <style>
    /* Minimal custom CSS */
    .navbar-gradient-warning {
      background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    }

    .required::after {
      content: " *";
      color: #dc3545;
    }
  </style>
</head>

<body class="bg-light">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-gradient-warning shadow-sm">
    <div class="container-fluid px-4">
      <a class="navbar-brand fw-bold fs-4" href="index.php">
        <i class="bi bi-tools me-2"></i>Campus Maintenance
      </a>
      <span class="navbar-text text-white">
        <i class="bi bi-pencil-square me-2"></i>Edit Issue #<?php echo $issue['id']; ?>
      </span>
    </div>
  </nav>

  <div class="container mt-4 mb-5">
    <!-- Alert Messages -->
    <?php if (isset($_SESSION['errors'])): ?>
      <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm border-start border-danger border-4" role="alert">
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
        <div class="card shadow border-0 rounded-4">
          <div class="card-header bg-warning text-dark border-0 p-4">
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