<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Campus Maintenance Issue Reporting System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    :root {
      --primary-color: #0d6efd;
      --secondary-color: #6c757d;
    }

    .navbar {
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .stat-card {
      transition: transform 0.2s;
      cursor: pointer;
    }

    .stat-card:hover {
      transform: translateY(-5px);
    }

    .table-actions .btn {
      margin: 0 2px;
    }

    .filter-section {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .badge-status {
      padding: 6px 12px;
      font-size: 0.875rem;
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
        Issue Reporting & Tracking
      </span>
    </div>
  </nav>

  <div class="container-fluid mt-4">
    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i>
        <?php
        echo $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['errors'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
        <div class="card text-white bg-warning stat-card" onclick="filterByStatus('Pending')">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title mb-0"><i class="bi bi-clock-history"></i> Pending</h6>
                <h2 class="mt-2 mb-0"><?php echo $pendingCount; ?></h2>
              </div>
              <i class="bi bi-clock" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-info stat-card" onclick="filterByStatus('In Progress')">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title mb-0"><i class="bi bi-gear-fill"></i> In Progress</h6>
                <h2 class="mt-2 mb-0"><?php echo $inProgressCount; ?></h2>
              </div>
              <i class="bi bi-gear" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-success stat-card" onclick="filterByStatus('Completed')">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title mb-0"><i class="bi bi-check-circle-fill"></i> Completed</h6>
                <h2 class="mt-2 mb-0"><?php echo $completedCount; ?></h2>
              </div>
              <i class="bi bi-check-circle" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-dark stat-card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title mb-0"><i class="bi bi-list-ul"></i> Total Issues</h6>
                <h2 class="mt-2 mb-0"><?php echo count($issues); ?></h2>
              </div>
              <i class="bi bi-folder" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="filter-section">
      <div class="row">
        <div class="col-md-3 mb-3 mb-md-0">
          <label class="form-label"><i class="bi bi-search"></i> Search</label>
          <input type="text" id="searchInput" class="form-control"
            placeholder="Search by title, location, User ID...">
        </div>
        <div class="col-md-2 mb-3 mb-md-0">
          <label class="form-label"><i class="bi bi-funnel"></i> Status</label>
          <select id="statusFilter" class="form-select">
            <option value="">All Status</option>
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
          </select>
        </div>
        <div class="col-md-2 mb-3 mb-md-0">
          <label class="form-label"><i class="bi bi-tag"></i> Category</label>
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
        <div class="col-md-2 mb-3 mb-md-0">
          <label class="form-label"><i class="bi bi-person"></i> User Role</label>
          <select id="userRoleFilter" class="form-select">
            <option value="">All Users</option>
            <option value="Student">Student</option>
            <option value="Staff">Staff</option>
            <option value="Instructor">Instructor</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">&nbsp;</label>
          <div class="d-grid gap-2">
            <button class="btn btn-secondary" onclick="clearFilters()">
              <i class="bi bi-x-circle"></i> Clear Filters
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Header with Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4><i class="bi bi-list-check"></i> All Maintenance Issues</h4>
      <a href="index.php?action=create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Report New Issue
      </a>
    </div>

    <!-- Issues Table -->
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover" id="issuesTable">
            <thead class="table-light">
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
            <tbody id="issuesTableBody">
              <?php if (empty($issues)): ?>
                <tr id="noDataRow">
                  <td colspan="9" class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No issues reported yet</p>
                    <a href="index.php?action=create" class="btn btn-primary">Report First Issue</a>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($issues as $issue): ?>
                  <tr data-status="<?php echo $issue['status']; ?>"
                    data-category="<?php echo $issue['category']; ?>"
                    data-user-role="<?php echo $issue['user_role']; ?>"
                    data-search-text="<?php echo strtolower($issue['title'] . ' ' . $issue['location'] . ' ' . $issue['user_id'] . ' ' . $issue['description']); ?>">
                    <td><strong>#<?php echo $issue['id']; ?></strong></td>
                    <td><code><?php echo htmlspecialchars($issue['user_id']); ?></code></td>
                    <td>
                      <span class="badge bg-secondary">
                        <?php echo $issue['user_role']; ?>
                      </span>
                    </td>
                    <td>
                      <strong><?php echo htmlspecialchars($issue['title']); ?></strong>
                      <?php if ($issue['image']): ?>
                        <i class="bi bi-image text-primary" title="Has image"></i>
                      <?php endif; ?>
                    </td>
                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($issue['category']); ?></span></td>
                    <td><?php echo htmlspecialchars($issue['location']); ?></td>
                    <td>
                      <?php
                      $statusClass = '';
                      switch ($issue['status']) {
                        case 'Pending':
                          $statusClass = 'bg-warning text-dark';
                          break;
                        case 'In Progress':
                          $statusClass = 'bg-info';
                          break;
                        case 'Completed':
                          $statusClass = 'bg-success';
                          break;
                      }
                      ?>
                      <span class="badge <?php echo $statusClass; ?> badge-status">
                        <?php echo $issue['status']; ?>
                      </span>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($issue['created_at'])); ?></td>
                    <td class="table-actions">
                      <a href="index.php?action=show&id=<?php echo $issue['id']; ?>"
                        class="btn btn-sm btn-info" title="View Details">
                        <i class="bi bi-eye"></i>
                      </a>
                      <a href="index.php?action=edit&id=<?php echo $issue['id']; ?>"
                        class="btn btn-sm btn-warning" title="Edit">
                        <i class="bi bi-pencil"></i>
                      </a>
                      <button type="button" class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal<?php echo $issue['id']; ?>"
                        title="Delete">
                        <i class="bi bi-trash"></i>
                      </button>

                      <!-- Delete Modal -->
                      <div class="modal fade" id="deleteModal<?php echo $issue['id']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                              <h5 class="modal-title">
                                <i class="bi bi-exclamation-triangle"></i> Confirm Delete
                              </h5>
                              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <p>Are you sure you want to delete this issue?</p>
                              <div class="alert alert-warning">
                                <strong>Issue #<?php echo $issue['id']; ?>:</strong><br>
                                <?php echo htmlspecialchars($issue['title']); ?>
                              </div>
                              <p class="text-danger"><strong>This action cannot be undone!</strong></p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x"></i> Cancel
                              </button>
                              <form method="POST" action="index.php?action=delete" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $issue['id']; ?>">
                                <button type="submit" class="btn btn-danger">
                                  <i class="bi bi-trash"></i> Delete Issue
                                </button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div id="noResultsMessage" class="text-center py-5" style="display: none;">
          <i class="bi bi-search" style="font-size: 3rem; color: #ccc;"></i>
          <p class="text-muted mt-3">No issues found matching your filters</p>
          <button class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Native JavaScript for Search and Filter functionality
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const userRoleFilter = document.getElementById('userRoleFilter');
    const tableBody = document.getElementById('issuesTableBody');
    const noResultsMessage = document.getElementById('noResultsMessage');

    // Apply filters function
    function applyFilters() {
      const searchTerm = searchInput.value.toLowerCase();
      const statusValue = statusFilter.value;
      const categoryValue = categoryFilter.value;
      const userRoleValue = userRoleFilter.value;

      const rows = tableBody.querySelectorAll('tr:not(#noDataRow)');
      let visibleCount = 0;

      rows.forEach(row => {
        const searchText = row.getAttribute('data-search-text') || '';
        const status = row.getAttribute('data-status') || '';
        const category = row.getAttribute('data-category') || '';
        const userRole = row.getAttribute('data-user-role') || '';

        let showRow = true;

        // Search filter
        if (searchTerm && !searchText.includes(searchTerm)) {
          showRow = false;
        }

        // Status filter
        if (statusValue && status !== statusValue) {
          showRow = false;
        }

        // Category filter
        if (categoryValue && category !== categoryValue) {
          showRow = false;
        }

        // User role filter
        if (userRoleValue && userRole !== userRoleValue) {
          showRow = false;
        }

        if (showRow) {
          row.style.display = '';
          visibleCount++;
        } else {
          row.style.display = 'none';
        }
      });

      // Show/hide no results message
      if (visibleCount === 0 && rows.length > 0) {
        noResultsMessage.style.display = 'block';
      } else {
        noResultsMessage.style.display = 'none';
      }
    }

    // Event listeners for real-time filtering
    searchInput.addEventListener('input', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
    categoryFilter.addEventListener('change', applyFilters);
    userRoleFilter.addEventListener('change', applyFilters);

    // Clear all filters
    function clearFilters() {
      searchInput.value = '';
      statusFilter.value = '';
      categoryFilter.value = '';
      userRoleFilter.value = '';
      applyFilters();
    }

    // Filter by status when clicking stat cards
    function filterByStatus(status) {
      statusFilter.value = status;
      applyFilters();
      // Scroll to table
      document.getElementById('issuesTable').scrollIntoView({
        behavior: 'smooth'
      });
    }

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      });
    }, 5000);
  </script>
</body>

</html>