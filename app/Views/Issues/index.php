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
    .stat-card {
      transition: transform 0.2s;
      cursor: pointer;
    }

    .stat-card:hover {
      transform: translateY(-5px);
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
        <div class="card text-white bg-warning stat-card" onclick="filterByStatus('Pending')">
          <div class="card-body">
            <h6><i class="bi bi-clock-history"></i> Pending</h6>
            <h2><?php echo $pendingCount; ?></h2>
            <small>Click to filter</small>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-white bg-info stat-card" onclick="filterByStatus('In Progress')">
          <div class="card-body">
            <h6><i class="bi bi-gear-fill"></i> In Progress</h6>
            <h2><?php echo $inProgressCount; ?></h2>
            <small>Click to filter</small>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-white bg-success stat-card" onclick="filterByStatus('Completed')">
          <div class="card-body">
            <h6><i class="bi bi-check-circle-fill"></i> Completed</h6>
            <h2><?php echo $completedCount; ?></h2>
            <small>Click to filter</small>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-white bg-dark stat-card" onclick="filterByStatus('')">
          <div class="card-body">
            <h6><i class="bi bi-list-ul"></i> Total Issues</h6>
            <h2 id="totalCount">-</h2>
            <small>Click to show all</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Custom Filter Row -->
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

  <script>
    // Auto-dismiss success/error alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
      const alerts = document.querySelectorAll('.alert-success, .alert-danger');
      alerts.forEach(function(alert) {
        setTimeout(function() {
          const bsAlert = new bootstrap.Alert(alert);
          bsAlert.close();
        }, 5000); // 5 seconds delay
      });
    });
  </script>

  <script>
    $(document).ready(function() {

      const table = $('#issuesTable').DataTable({
        ajax: {
          url: 'index.php?action=getIssuesJson',
          dataSrc: 'data'
        },
        columns: [{
            data: 'id',
            render: d => `<strong>#${d}</strong>`
          },
          {
            data: 'user_id',
            render: d => `<code>${d}</code>`
          },
          {
            data: 'user_role',
            render: d => `<span class="badge bg-secondary">${d}</span>`
          },
          {
            data: 'title',
            render: (d, t, r) => `<strong>${r.image ? '<i class="bi bi-image text-primary"></i> ' : ''}${d}</strong>`
          },
          {
            data: 'category',
            render: d => `<span class="badge bg-secondary">${d}</span>`
          },
          {
            data: 'location'
          },
          {
            data: 'status',
            render: d => {
              const cls = {
                'Pending': 'bg-warning text-dark',
                'In Progress': 'bg-info',
                'Completed': 'bg-success'
              };
              return `<span class="badge ${cls[d]} badge-status">${d}</span>`;
            }
          },
          {
            data: 'created_date'
          },
          {
            data: null,
            orderable: false,
            render: (d, t, r) => `
              <div class="btn-group btn-group-sm">
                <a href="index.php?action=show&id=${r.id}" class="btn btn-info"><i class="bi bi-eye"></i></a>
                <a href="index.php?action=edit&id=${r.id}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                <button class="btn btn-danger delete-btn" data-id="${r.id}" data-title="${r.title}">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            `
          }
        ],
        order: [
          [0, 'desc']
        ],
        pageLength: 10,
        drawCallback: function() {
          const info = this.api().page.info();
          $('#totalCount').text(info.recordsTotal);
        }
      });

      // Hidden status filter
      $('body').append('<input type="hidden" id="statusFilterHidden" value="">');

      // CLEAN HTML BADGE TEXT → raw string
      function extractText(html) {
        return $('<div>').html(html).text().trim();
      }

      // Update current filter display
      function updateCurrentFilter() {
        const status = $('#statusFilterHidden').val();
        const cat = $('#categoryFilter').val();
        const role = $('#roleFilter').val();
        const filters = [];
        if (status) filters.push(status);
        if (cat) filters.push(cat);
        if (role) filters.push(role);
        let text;
        if (filters.length === 0) {
          text = 'All Issues';
        } else if (filters.length === 1) {
          const f = filters[0];
          if (f === status) {
            text = f;
          } else if (f === cat) {
            text = `Category: ${f}`;
          } else {
            text = `Role: ${f}`;
          }
        } else {
          text = 'Multiple Filters';
        }
        $('#currentFilter').text(text);
      }

      // FIXED FILTER LOGIC
      $.fn.dataTable.ext.search.push(function(settings, data) {

        const statusFilter = $('#statusFilterHidden').val();
        const categoryFilter = $('#categoryFilter').val();
        const roleFilter = $('#roleFilter').val();

        const rowRole = extractText(data[2]);
        const rowCategory = extractText(data[4]);
        const rowStatus = extractText(data[6]);

        if (statusFilter && rowStatus !== statusFilter) return false;
        if (categoryFilter && rowCategory !== categoryFilter) return false;
        if (roleFilter && rowRole !== roleFilter) return false;

        return true;
      });

      // Status card filter
      window.filterByStatus = function(status) {
        // Clear other filters when applying status filter for consistency
        $('#categoryFilter').val('');
        $('#roleFilter').val('');
        $('#statusFilterHidden').val(status);
        table.draw();
        updateCurrentFilter();
        $('#clearFilters').toggle(status !== '');
      };

      // Dropdown filters
      $('#categoryFilter, #roleFilter').on('change', function() {
        table.draw();
        updateCurrentFilter();
        const isFiltering =
          $('#categoryFilter').val() ||
          $('#roleFilter').val() ||
          $('#statusFilterHidden').val();
        $('#clearFilters').toggle(!!isFiltering);
      });

      // Clear filters
      $('#clearFilters').on('click', function() {
        $('#statusFilterHidden').val('');
        $('#categoryFilter').val('');
        $('#roleFilter').val('');
        updateCurrentFilter();
        table.draw();
        $(this).hide();
      });

      // Delete modal
      $(document).on('click', '.delete-btn', function() {
        $('#deleteIssueId').val($(this).data('id'));
        $('#deleteIssueName').text($(this).data('title'));
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
      });

      // Initial update
      updateCurrentFilter();

    });
  </script>

</body>

</html>