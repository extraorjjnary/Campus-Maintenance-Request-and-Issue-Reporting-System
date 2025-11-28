<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Issue #<?php echo $issue['id']; ?> - Campus Maintenance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    .id-format-help {
      font-size: 0.875rem;
      margin-top: 5px;
    }

    .invalid-feedback {
      display: block;
    }

    .form-label.required::after {
      content: " *";
      color: red;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <i class="bi bi-tools"></i> Campus Maintenance System
      </a>
      <span class="navbar-text text-white">
        Edit Issue
      </span>
    </div>
  </nav>

  <div class="container mt-4">
    <!-- Alert Messages -->
    <?php if (isset($_SESSION['errors'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> <strong>Validation Errors:</strong>
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
      <div class="col-md-10">
        <div class="card shadow-sm">
          <div class="card-header bg-warning">
            <h4 class="mb-0"><i class="bi bi-pencil"></i> Edit Issue #<?php echo $issue['id']; ?></h4>
            <small>Update the issue information below</small>
          </div>
          <div class="card-body">
            <?php
            // Set variables for form partial
            $action = 'index.php?action=update';
            $method = 'POST';
            $isEdit = true;
            // $issue is already available from the controller

            // Include the reusable form partial
            // ✅ CORRECT PATH: __DIR__ points to current directory (app/Views/issues/)
            // So partials/form.php is in the same level
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
  <!-- ✅ CORRECT PATH: These are relative to the browser URL (public/index.php) -->
  <!-- Browser looks for: public/js/validation.js -->
  <script src="js/validation.js"></script>
  <script src="js/preview.js"></script>
</body>

</html>