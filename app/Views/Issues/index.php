<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Campus Maintenance System</title>

  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/dataTables.bootstrap5.min.css">

  <style>
    /* Enhanced purple gradient background */
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

    .stat-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
    }

    .stat-gradient-warning {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stat-gradient-info {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-gradient-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-gradient-dark {
      background: linear-gradient(135deg, #5a67d8 0%, #4c51bf 100%);
    }

    .modal-backdrop {
      z-index: 1040 !important;
      /* Slightly higher if needed */
    }

    .modal {
      z-index: 1055 !important;
      /* Bumps dialog above backdrop and any navbars */
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

        <!-- Right Side Actions -->
        <div class="d-flex align-items-center gap-2 gap-md-3">
          <div class="d-none d-md-flex align-items-center gap-2 text-white bg-white bg-opacity-10 rounded-pill px-3 py-2">
            <i class="bi bi-speedometer2"></i>
            <span class="fw-semibold small">Dashboard</span>
          </div>

          <div class="vr bg-white opacity-25 d-none d-md-block" style="height: 30px;"></div>

          <div class="dropdown">
            <button class="btn btn-light rounded-pill px-3 px-md-4 fw-semibold dropdown-toggle"
              type="button"
              id="adminDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="bi bi-person-circle me-1"></i>
              <span class="d-none d-sm-inline">Admin</span>
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

          <a href="index.php?action=create" class="btn btn-warning fw-semibold rounded-pill px-3 px-md-4 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i>
            <span class="d-none d-sm-inline">Report Issue</span>
            <span class="d-sm-none">New</span>
          </a>
        </div>
      </div>
    </nav>

    <div class="container-fluid px-3 px-md-4 py-4">

      <!-- SUCCESS -->
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow border-start border-success border-5 bg-white" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i><strong><?php echo $_SESSION['success'];
                                                              unset($_SESSION['success']); ?></strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- ERRORS -->
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

      <!-- Page Header -->
      <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
          <div>
            <h4 class="fw-bold text-dark mb-1">
              <i class="bi bi-house-gear-fill text-primary me-2"></i>Maintenance Dashboard
            </h4>
            <p class="text-muted mb-0 small">Monitor and manage campus maintenance issues</p>
          </div>
          <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 rounded-pill">
              <i class="bi bi-calendar-event me-1"></i>
              <?php echo date('F d, Y'); ?>
            </span>
          </div>
        </div>
      </div>

      <!-- Dashboard Statistics -->
      <div class="row g-3 g-lg-4 mb-4">
        <div class="col-lg-3 col-sm-6">
          <div class="card text-white stat-gradient-warning stat-card shadow border-0 h-100">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <div class="text-uppercase fw-semibold mb-2 opacity-90 small">
                    <i class="bi bi-clock-history me-1"></i>Pending
                  </div>
                  <h2 class="fw-bold mb-1 display-5" id="pendingCount"><?php echo $pendingCount; ?></h2>
                  <small class="opacity-75">Awaiting Review</small>
                </div>
                <div class="bg-white bg-opacity-25 rounded-3 p-3">
                  <i class="bi bi-clock-history fs-2"></i>
                </div>
              </div>
            </div>
            <div class="card-footer bg-black bg-opacity-10 border-0 py-2 text-center">
              <small class="fw-semibold">⏳ Needs Attention</small>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-sm-6">
          <div class="card text-white stat-gradient-info stat-card shadow border-0 h-100">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <div class="text-uppercase fw-semibold mb-2 opacity-90 small">
                    <i class="bi bi-gear-fill me-1"></i>In Progress
                  </div>
                  <h2 class="fw-bold mb-1 display-5" id="inProgressCount"><?php echo $inProgressCount; ?></h2>
                  <small class="opacity-75">Being Worked On</small>
                </div>
                <div class="bg-white bg-opacity-25 rounded-3 p-3">
                  <i class="bi bi-gear-fill fs-2"></i>
                </div>
              </div>
            </div>
            <div class="card-footer bg-black bg-opacity-10 border-0 py-2 text-center">
              <small class="fw-semibold">⚙️ Active Tasks</small>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-sm-6">
          <div class="card text-white stat-gradient-success stat-card shadow border-0 h-100">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <div class="text-uppercase fw-semibold mb-2 opacity-90 small">
                    <i class="bi bi-check-circle-fill me-1"></i>Completed
                  </div>
                  <h2 class="fw-bold mb-1 display-5" id="completedCount"><?php echo $completedCount; ?></h2>
                  <small class="opacity-75">Successfully Resolved</small>
                </div>
                <div class="bg-white bg-opacity-25 rounded-3 p-3">
                  <i class="bi bi-check-circle-fill fs-2"></i>
                </div>
              </div>
            </div>
            <div class="card-footer bg-black bg-opacity-10 border-0 py-2 text-center">
              <small class="fw-semibold">✅ All Done</small>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-sm-6">
          <div class="card text-white stat-gradient-dark stat-card shadow border-0 h-100">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <div class="text-uppercase fw-semibold mb-2 opacity-90 small">
                    <i class="bi bi-list-ul me-1"></i>Total Issues
                  </div>
                  <h2 class="fw-bold mb-1 display-5" id="totalCount">-</h2>
                  <small class="opacity-75">All Reports</small>
                </div>
                <div class="bg-white bg-opacity-25 rounded-3 p-3">
                  <i class="bi bi-list-ul fs-2"></i>
                </div>
              </div>
            </div>
            <div class="card-footer bg-black bg-opacity-10 border-0 py-2 text-center">
              <small class="fw-semibold">📊 Overall Count</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter Section -->
      <div class="card shadow-sm border-0 rounded-4 mb-4 bg-white">
        <div class="card-body p-4">
          <h5 class="fw-bold text-dark mb-3">
            <i class="bi bi-funnel-fill text-primary me-2"></i>Filter Issues
          </h5>
          <div class="row g-3 align-items-end">
            <div class="col-lg-3 col-md-6">
              <label class="form-label fw-semibold text-secondary small mb-2">
                <i class="bi bi-tag me-1"></i>Category
              </label>
              <select id="categoryFilter" class="form-select form-select-lg rounded-3 border-2">
                <option value="">All Categories</option>
                <option value="Plumbing">🚰 Plumbing</option>
                <option value="Electrical">⚡ Electrical</option>
                <option value="Infrastructure">🏗️ Infrastructure</option>
                <option value="HVAC">❄️ HVAC</option>
                <option value="Equipment">🔧 Equipment</option>
                <option value="Furniture">🪑 Furniture</option>
                <option value="Landscaping">🌳 Landscaping</option>
                <option value="Other">📦 Other</option>
              </select>
            </div>

            <div class="col-lg-3 col-md-6">
              <label class="form-label fw-semibold text-secondary small mb-2">
                <i class="bi bi-person me-1"></i>User Role
              </label>
              <select id="roleFilter" class="form-select form-select-lg rounded-3 border-2">
                <option value="">All Roles</option>
                <option value="Student">👨‍🎓 Student</option>
                <option value="Staff">👔 Staff</option>
                <option value="Instructor">👨‍🏫 Instructor</option>
              </select>
            </div>

            <div class="col-lg-3 col-md-6">
              <label class="form-label fw-semibold text-secondary small mb-2">
                <i class="bi bi-toggle-on me-1"></i>Status
              </label>
              <select id="statusFilter" class="form-select form-select-lg rounded-3 border-2">
                <option value="">All Statuses</option>
                <option value="Pending">⏳ Pending</option>
                <option value="In Progress">⚙️ In Progress</option>
                <option value="Completed">✅ Completed</option>
              </select>
            </div>

            <div class="col-lg-3 col-md-6">
              <label class="form-label fw-semibold text-secondary small mb-2">Active Filter</label>
              <div class="d-flex align-items-center gap-2">
                <span id="currentFilter" class="badge bg-primary fs-6 px-3 py-2 rounded-pill flex-grow-1 text-center">
                  All Issues
                </span>
                <button id="clearFilters" class="btn btn-outline-secondary rounded-pill px-3" style="display:none">
                  <i class="bi bi-x-circle"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Issues Table -->
      <div class="card shadow-sm border-0 rounded-4 bg-white">
        <div class="card-header bg-primary bg-opacity-10 border-0 p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h5 class="fw-bold text-dark mb-0">
              <i class="bi bi-list-check text-primary me-2"></i>All Maintenance Issues
            </h5>
            <a href="index.php?action=create" class="btn btn-primary rounded-pill px-4 shadow-sm fw-semibold">
              <i class="bi bi-plus-circle me-2"></i>Report New Issue
            </a>
          </div>
        </div>
        <div class="card-body p-4">
          <div class="table-responsive">
            <table id="issuesTable" class="table table-hover align-middle" style="width:100%">
              <thead class="table-light">
                <tr>
                  <th class="fw-bold text-uppercase small text-secondary">ID</th>
                  <th class="fw-bold text-uppercase small text-secondary">User ID</th>
                  <th class="fw-bold text-uppercase small text-secondary">Role</th>
                  <th class="fw-bold text-uppercase small text-secondary">Title</th>
                  <th class="fw-bold text-uppercase small text-secondary">Category</th>
                  <th class="fw-bold text-uppercase small text-secondary">Location</th>
                  <th class="fw-bold text-uppercase small text-secondary">Status</th>
                  <th class="fw-bold text-uppercase small text-secondary">Date</th>
                  <th class="fw-bold text-uppercase small text-secondary">Actions</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


  </div>

  <!-- JS -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap5.min.js"></script>

  <!-- Custom JavaScript Files -->
  <script src="js/alerts.js"></script>
  <script src="js/dashboard.js"></script>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4">
        <div class="modal-header bg-danger text-white border-0 rounded-top-4">
          <h5 class="modal-title fw-bold">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Deletion
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <p class="mb-3">Are you sure you want to delete this issue?</p>
          <div class="alert alert-warning border-0 bg-warning bg-opacity-10 border-start border-warning border-4 mb-3">
            <strong class="d-block mb-1">Issue Title:</strong>
            <span id="deleteIssueName" class="text-dark"></span>
          </div>
          <p class="text-danger fw-bold mb-0">
            <i class="bi bi-exclamation-circle me-1"></i>This action cannot be undone!
          </p>
        </div>
        <div class="modal-footer border-0 bg-light rounded-bottom-4">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
            <i class="bi bi-x me-1"></i>Cancel
          </button>
          <form method="POST" action="index.php?action=delete" id="deleteForm" class="d-inline">
            <input type="hidden" name="id" id="deleteIssueId">
            <button type="submit" class="btn btn-danger rounded-pill px-4">
              <i class="bi bi-trash me-2"></i>Delete Issue
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

</html>