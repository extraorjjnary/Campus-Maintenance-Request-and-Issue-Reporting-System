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
    /* Minimal custom for stat card hover (visual only, no click) */
    .stat-card {
      transition: transform 0.2s;
      cursor: default;
    }

    .stat-card:hover {
      transform: translateY(-5px);
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
      <span class="navbar-text text-white">Issue Reporting & Tracking</span>
    </div>
  </nav>

  <div class="container-fluid mt-4">

    <!-- SUCCESS -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> <?php echo $_SESSION['success'];
                                            unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- ERRORS -->
    <?php if (isset($_SESSION['errors'])): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle"></i>
        <ul class="mb-0">
          <?php foreach ($_SESSION['errors'] as $error): ?>
            <li><?php echo $error; ?></li>
          <?php endforeach; ?>
        </ul>
        <?php unset($_SESSION['errors']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Dashboard Statistics -->
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="card text-white bg-warning stat-card">
          <div class="card-body">
            <h6><i class="bi bi-clock-history"></i> Pending</h6>
            <h2 id="pendingCount"><?php echo $pendingCount; ?></h2>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-white bg-info stat-card">
          <div class="card-body">
            <h6><i class="bi bi-gear-fill"></i> In Progress</h6>
            <h2 id="inProgressCount"><?php echo $inProgressCount; ?></h2>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-white bg-success stat-card">
          <div class="card-body">
            <h6><i class="bi bi-check-circle-fill"></i> Completed</h6>
            <h2 id="completedCount"><?php echo $completedCount; ?></h2>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-white bg-dark stat-card">
          <div class="card-body">
            <h6><i class="bi bi-list-ul"></i> Total Issues</h6>
            <h2 id="totalCount">-</h2>
          </div>
        </div>
      </div>
    </div>

    <!-- Custom Filter Row (Added Status Dropdown) -->
    <div class="row mb-3">
      <div class="col-md-3">
        <label class="form-label">Filter by Category:</label>
        <select id="categoryFilter" class="form-select">
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
        <label class="form-label">Filter by User Role:</label>
        <select id="roleFilter" class="form-select">
          <option value="">All Roles</option>
          <option value="Student">Student</option>
          <option value="Staff">Staff</option>
          <option value="Instructor">Instructor</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Filter by Status:</label>
        <select id="statusFilter" class="form-select">
          <option value="">All Statuses</option>
          <option value="Pending">Pending</option>
          <option value="In Progress">In Progress</option>
          <option value="Completed">Completed</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Current Filter:</label>
        <div class="d-flex align-items-center">
          <span id="currentFilter" class="badge bg-secondary fs-6">All Issues</span>
          <button id="clearFilters" class="btn btn-sm btn-outline-secondary ms-2" style="display:none">
            <i class="bi bi-x-circle"></i> Clear
          </button>
        </div>
      </div>
    </div>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4><i class="bi bi-list-check"></i> All Maintenance Issues</h4>
      <a href="index.php?action=create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Report New Issue
      </a>
    </div>

    <!-- Issues Table -->
    <div class="card shadow-sm">
      <div class="card-body">
        <table id="issuesTable" class="table table-hover table-striped" style="width:100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>User ID</th>
              <th>Role</th>
              <th>Title</th>
              <th>Category</th>
              <th>Location</th>
              <th>Status</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Confirm Delete</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this issue?</p>
          <div class="alert alert-warning">
            <strong>Issue:</strong> <span id="deleteIssueName"></span>
          </div>
          <p class="text-danger"><strong>This action cannot be undone!</strong></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <form method="POST" action="index.php?action=delete" id="deleteForm">
            <input type="hidden" name="id" id="deleteIssueId">
            <button type="submit" class="btn btn-danger">Delete Issue</button>
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