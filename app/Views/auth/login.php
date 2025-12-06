<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Campus Maintenance</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap-icons.css">

  <style>
    body {
      background: linear-gradient(to bottom, #e0e7ff 0%, #f3f4f6 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      max-width: 450px;
      width: 100%;
      padding: 20px;
    }

    .login-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
      overflow: hidden;
    }

    .login-header {
      background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
      padding: 40px 30px;
      text-align: center;
      color: white;
    }

    .login-icon {
      width: 80px;
      height: 80px;
      background: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .login-icon i {
      font-size: 2.5rem;
      color: #1e40af;
    }

    .login-body {
      padding: 40px 30px;
    }

    .form-control {
      padding: 12px 15px;
      border: 2px solid #e5e7eb;
      border-radius: 10px;
      font-size: 1rem;
    }

    .form-control:focus {
      border-color: #1e40af;
      box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.1);
    }

    .input-group-text {
      background: transparent;
      border: 2px solid #e5e7eb;
      border-right: none;
      border-radius: 10px 0 0 10px;
    }

    .input-group .form-control {
      border-left: none;
      border-radius: 0 10px 10px 0;
    }

    .btn-login {
      padding: 12px;
      font-size: 1.1rem;
      font-weight: bold;
      border-radius: 10px;
      background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
      border: none;
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(30, 64, 175, 0.3);
    }

    .back-link {
      text-align: center;
      margin-top: 20px;
    }

    .back-link a {
      color: #1e40af;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .back-link a:hover {
      color: #1e3a8a;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <div class="login-icon">
          <i class="bi bi-shield-lock-fill"></i>
        </div>
        <h3 class="fw-bold mb-2">Admin Portal</h3>
        <p class="mb-0 opacity-90">Campus Maintenance System</p>
      </div>

      <div class="login-body">
        <!-- Error Messages -->
        <?php if (isset($_SESSION['errors'])): ?>
          <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php
            foreach ($_SESSION['errors'] as $error) {
              echo $error;
            }
            unset($_SESSION['errors']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <form method="POST" action="index.php?action=login" id="loginForm">
          <div class="mb-4">
            <label class="form-label fw-semibold text-secondary">
              <i class="bi bi-person-fill me-1"></i>Username
            </label>
            <div class="input-group">
              <span class="input-group-text">
                <i class="bi bi-person"></i>
              </span>
              <input type="text"
                class="form-control"
                name="username"
                placeholder="Enter admin username"
                required
                autofocus>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold text-secondary">
              <i class="bi bi-lock-fill me-1"></i>Password
            </label>
            <div class="input-group">
              <span class="input-group-text">
                <i class="bi bi-lock"></i>
              </span>
              <input type="password"
                class="form-control"
                name="password"
                id="password"
                placeholder="Enter admin password"
                required>
              <button class="btn btn-outline-secondary"
                type="button"
                id="togglePassword"
                style="border: 2px solid #e5e7eb; border-left: none; border-radius: 0 10px 10px 0;">
                <i class="bi bi-eye" id="toggleIcon"></i>
              </button>
            </div>
          </div>

          <button type="submit" class="btn btn-primary btn-login w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
          </button>
        </form>

        <div class="back-link">
          <a href="landing.php">
            <i class="bi bi-arrow-left me-1"></i>Back to Landing Page
          </a>
        </div>
      </div>
    </div>

    <p class="text-center text-muted mt-4 small">
      <i class="bi bi-info-circle me-1"></i>Admin access only
    </p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

    // Auto-dismiss alerts
    document.addEventListener('DOMContentLoaded', function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(function(alert) {
        setTimeout(function() {
          const bsAlert = new bootstrap.Alert(alert);
          bsAlert.close();
        }, 5000);
      });
    });
  </script>
</body>

</html>