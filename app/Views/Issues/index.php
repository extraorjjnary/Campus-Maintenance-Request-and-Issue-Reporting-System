<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Campus Maintenance System</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

  <style>
    /* Minimal custom CSS - only what Bootstrap can't do */
    .stat-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .navbar-gradient {
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }

    .stat-gradient-warning {
      background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    }

    .stat-gradient-info {
      background: linear-gradient(135deg, #0dcaf0 0%, #0891b2 100%);
    }

    .stat-gradient-success {
      background: linear-gradient(135deg, #198754 0%, #157347 100%);
    }

    .stat-gradient-dark {
      background: linear-gradient(135deg, #212529 0%, #000 100%);
    }
  </style>
</head>

<body class="bg-light">
  <!-- Modern Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-gradient shadow-sm">
    <div class="container-fluid px-4">
      <a class="navbar-brand fw-bold fs-4" href="index.php">
        <i class="bi bi-tools me-2"></i>Campus Maintenance
      </a>
      <span class="navbar-text text-white">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
      </span>
    </div>
  </nav>

  <div class="container-fluid mt-4 px-4 pb-5">

    <!-- SUCCESS -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm border-start border-success border-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><strong><?php echo $_SESSION['success'];
                                                            unset($_SESSION['success']); ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- ERRORS -->
    <?php if (isset($_SESSION['errors'])): ?>
      <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm border-start border-danger border-4" role="alert">
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

    <!-- Dashboard Statistics -->
    <div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6">
        <div class="card text-white stat-gradient-warning stat-card shadow border-0 h-100">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="text-uppercase fw-bold mb-2 opacity-90"><i class="bi bi-clock-history me-2"></i>Pending</h6>
                <h2 class="fw-bold mb-0 display-4" id="pendingCount"><?php echo $pendingCount; ?></h2>
              </div>
              <div>
                <i class="bi bi-clock-history display-4 opacity-50"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card text-white stat-gradient-info stat-card shadow border-0 h-100">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="text-uppercase fw-bold mb-2 opacity-90"><i class="bi bi-gear-fill me-2"></i>In Progress</h6>
                <h2 class="fw-bold mb-0 display-4" id="inProgressCount"><?php echo $inProgressCount; ?></h2>
              </div>
              <div>
                <i class="bi bi-gear-fill display-4 opacity-50"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card text-white stat-gradient-success stat-card shadow border-0 h-100">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="text-uppercase fw-bold mb-2 opacity-90"><i class="bi bi-check-circle-fill me-2"></i>Completed</h6>
                <h2 class="fw-bold mb-0 display-4" id="completedCount"><?php echo $completedCount; ?></h2>
              </div>
              <div>
                <i class="bi bi-check-circle-fill display-4 opacity-50"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="card text-white stat-gradient-dark stat-card shadow border-0 h-100">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="text-uppercase fw-bold mb-2 opacity-90"><i class="bi bi-list-ul me-2"></i>Total Issues</h6>
                <h2 class="fw-bold mb-0 display-4" id="totalCount">-</h2>
              </div>
              <div>
                <i class="bi bi-list-ul display-4 opacity-50"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm border-0 rounded-3 mb-4">
      <div class="card-body p-4">
        <div class="row g-3 align-items-end">
          <div class="col-md-3">
            <label class="form-label fw-bold text-uppercase small text-secondary mb-2">
              <i class="bi bi-funnel me-1"></i>Filter by Category
            </label>
            <select id="categoryFilter" class="form-select rounded-3">
              <option value="">All Categories</option>
              <option value="Plumbing">Plumbing</option>
              <option value="Electrical">Electrical</option>
              <option value="Infrastructure">Infrastructure</option>
              <option value="HVAC">HVAC</option>
              <option value="Equipment">Equipment</option>
              <option value="Furniture">Furniture</option>
              <option value="Landscaping">Landscaping</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label fw-bold text-uppercase small text-secondary mb-2">
              <i class="bi bi-person me-1"></i>Filter by User Role
            </label>
            <select id="roleFilter" class="form-select rounded-3">
              <option value="">All Roles</option>
              <option value="Student">Student</option>
              <option value="Staff">Staff</option>
              <option value="Instructor">Instructor</option>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label fw-bold text-uppercase small text-secondary mb-2">
              <i class="bi bi-toggle-on me-1"></i>Filter by Status
            </label>
            <select id="statusFilter" class="form-select rounded-3">
              <option value="">All Statuses</option>
              <option value="Pending">Pending</option>
              <option value="In Progress">In Progress</option>
              <option value="Completed">Completed</option>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label fw-bold text-uppercase small text-secondary mb-2">Active Filter</label>
            <div class="d-flex align-items-center gap-2">
              <span id="currentFilter" class="badge bg-primary fs-6 px-3 py-2 rounded-pill">All Issues</span>
              <button id="clearFilters" class="btn btn-outline-secondary btn-sm rounded-pill" style="display:none">
                <i class="bi bi-x-circle me-1"></i>Clear
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold text-dark mb-0">
        <i class="bi bi-list-check text-primary me-2"></i>Maintenance Issues
      </h4>
      <a href="index.php?action=create" class="btn btn-primary btn-lg rounded-3 shadow-sm">
        <i class="bi bi-plus-circle me-2"></i>Report New Issue
      </a>
    </div>

    <!-- Issues Table -->
    <div class="card shadow-sm border-0 rounded-3">
      <div class="card-body p-4">
        <table id="issuesTable" class="table table-hover align-middle" style="width:100%">
          <thead class="table-light">
            <tr>
              <th class="fw-bold text-uppercase small">ID</th>
              <th class="fw-bold text-uppercase small">User ID</th>
              <th class="fw-bold text-uppercase small">Role</th>
              <th class="fw-bold text-uppercase small">Title</th>
              <th class="fw-bold text-uppercase small">Category</th>
              <th class="fw-bold text-uppercase small">Location</th>
              <th class="fw-bold text-uppercase small">Status</th>
              <th class="fw-bold text-uppercase small">Date</th>
              <th class="fw-bold text-uppercase small">Actions</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <div class="modal-header bg-danger text-white border-0">
          <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle me-2"></i>Confirm Delete</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <p class="mb-3">Are you sure you want to delete this issue?</p>
          <div class="alert alert-warning border-0 mb-3">
            <strong>Issue:</strong> <span id="deleteIssueName"></span>
          </div>
          <p class="text-danger fw-bold mb-0">
            <i class="bi bi-exclamation-circle me-1"></i>This action cannot be undone!
          </p>
        </div>
        <div class="modal-footer border-0 bg-light">
          <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
          <form method="POST" action="index.php?action=delete" id="deleteForm" class="d-inline">
            <input type="hidden" name="id" id="deleteIssueId">
            <button type="submit" class="btn btn-danger rounded-3">
              <i class="bi bi-trash me-2"></i>Delete Issue
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

  <!-- Custom JavaScript Files -->
  <script src="js/alerts.js"></script>
  <script src="js/dashboard.js"></script>

</body>

</html>