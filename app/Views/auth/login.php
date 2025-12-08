<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Campus Maintenance</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap-icons.css">

  <style>
    /* Only essential CSS that Bootstrap can't do */
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

    .login-header {
      background: linear-gradient(135deg, #5a67d8 0%, #4c51bf 100%);
    }

    .btn-login {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .btn-login:hover {
      transform: translateY(-2px);
    }
  </style>
</head>

<body class="min-vh-100 d-flex align-items-center justify-content-center">
  <div class="content-wrapper w-100">
    <div class="container" style="max-width: 450px;">
      <!-- Success Alert -->
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3 border-start border-success border-4" role="alert" id="successAlert">
          <i class="bi bi-check-circle-fill me-2"></i>
          <strong><?php echo htmlspecialchars($_SESSION['success']);
                  unset($_SESSION['success']); ?></strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Error Alert -->
      <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3 border-start border-danger border-4" role="alert" id="errorAlert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>
          <strong>
            <?php
            foreach ($_SESSION['errors'] as $error) {
              echo htmlspecialchars($error);
            }
            unset($_SESSION['errors']);
            ?>
          </strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Login Card -->
      <div class="card border-0 rounded-4 shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="login-header text-white text-center py-5">
          <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow" style="width: 80px; height: 80px;">
            <i class="bi bi-shield-lock-fill text-primary" style="font-size: 2.5rem;"></i>
          </div>
          <h3 class="fw-bold mb-2">Admin Portal</h3>
          <p class="mb-0 opacity-75">Campus Maintenance System</p>
        </div>

        <!-- Body -->
        <div class="card-body p-4 p-md-5">
          <form method="POST" action="index.php?action=login" id="loginForm">
            <!-- Username -->
            <div class="mb-4">
              <label class="form-label fw-semibold text-secondary">
                <i class="bi bi-person-fill me-1"></i>Username
              </label>
              <div class="input-group input-group-lg">
                <span class="input-group-text bg-light border-end-0">
                  <i class="bi bi-person text-secondary"></i>
                </span>
                <input type="text"
                  class="form-control border-start-0 ps-0"
                  name="username"
                  placeholder="Enter admin username"
                  required
                  autofocus>
              </div>
            </div>

            <!-- Password -->
            <div class="mb-4">
              <label class="form-label fw-semibold text-secondary">
                <i class="bi bi-lock-fill me-1"></i>Password
              </label>
              <div class="input-group input-group-lg">
                <span class="input-group-text bg-light border-end-0">
                  <i class="bi bi-lock text-secondary"></i>
                </span>
                <input type="password"
                  class="form-control border-start-0 border-end-0 ps-0"
                  name="password"
                  id="password"
                  placeholder="Enter admin password"
                  required>
                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                  <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
              </div>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn btn-primary btn-lg btn-login w-100 fw-bold border-0 shadow-sm">
              <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </button>
          </form>

          <!-- Back Link -->
          <div class="text-center mt-4">
            <a href="landing.php" class="text-decoration-none fw-semibold">
              <i class="bi bi-arrow-left me-1"></i>Back to Landing Page
            </a>
          </div>
        </div>
      </div>

      <!-- Footer Text -->
      <p class="text-center text-muted mt-4 small mb-0">
        <i class="bi bi-info-circle me-1"></i>Admin access only
      </p>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script>
      // Toggle password visibility
      document.getElementById('togglePassword').addEventListener('click', function() {
        const password = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');

        if (password.type === 'password') {
          password.type = 'text';
          icon.classList.remove('bi-eye');
          icon.classList.add('bi-eye-slash');
        } else {
          password.type = 'password';
          icon.classList.remove('bi-eye-slash');
          icon.classList.add('bi-eye');
        }
      });

      // Auto-dismiss alerts after 4 seconds
      document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
          setTimeout(function() {
            const bsAlert = new bootstrap.Alert(successAlert);
            bsAlert.close();
          }, 4000);
        }

        const errorAlert = document.getElementById('errorAlert');
        if (errorAlert) {
          setTimeout(function() {
            const bsAlert = new bootstrap.Alert(errorAlert);
            bsAlert.close();
          }, 4000);
        }
      });
    </script>
</body>

</html>