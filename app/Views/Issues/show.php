<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Issue #<?php echo $issue['id']; ?> - Campus Maintenance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    .info-label {
      font-weight: 600;
      color: #6c757d;
      margin-bottom: 5px;
    }

    .info-value {
      font-size: 1.1rem;
      margin-bottom: 20px;
    }

    .status-update-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
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
        Issue Details
      </span>
    </div>
  </nav>

  <div class="container mt-4">
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
        <?php
        echo implode('<br>', $_SESSION['errors']);
        unset($_SESSION['errors']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-8">
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-eye"></i> Issue #<?php echo $issue['id']; ?></h4>
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
            <span class="badge <?php echo $statusClass; ?> fs-6">
              <?php echo $issue['status']; ?>
            </span>
          </div>
          <div class="card-body">
            <!-- Issue Title -->
            <h3 class="mb-4"><?php echo htmlspecialchars($issue['title']); ?></h3>

            <!-- Reporter Information -->
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="info-label">
                  <i class="bi bi-person-badge"></i> Reported By (User ID)
                </div>
                <div class="info-value">
                  <code class="fs-5"><?php echo htmlspecialchars($issue['user_id']); ?></code>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-label">
                  <i class="bi bi-person"></i> User Role
                </div>
                <div class="info-value">
                  <span class="badge bg-secondary fs-6">
                    <?php echo htmlspecialchars($issue['user_role']); ?>
                  </span>
                </div>
              </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
              <div class="info-label">
                <i class="bi bi-card-text"></i> Description
              </div>
              <div class="info-value">
                <?php echo nl2br(htmlspecialchars($issue['description'])); ?>
              </div>
            </div>

            <!-- Issue Details -->
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="info-label">
                  <i class="bi bi-tag"></i> Category
                </div>
                <div class="info-value">
                  <span class="badge bg-secondary fs-6">
                    <?php echo htmlspecialchars($issue['category']); ?>
                  </span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-label">
                  <i class="bi bi-geo-alt"></i> Location
                </div>
                <div class="info-value">
                  <?php echo htmlspecialchars($issue['location']); ?>
                </div>
              </div>
            </div>

            <!-- Timestamps -->
            <div class="row">
              <div class="col-md-6">
                <div class="info-label">
                  <i class="bi bi-calendar-plus"></i> Created At
                </div>
                <div class="info-value">
                  <?php echo date('F d, Y', strtotime($issue['created_at'])); ?><br>
                  <small class="text-muted"><?php echo date('h:i A', strtotime($issue['created_at'])); ?></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-label">
                  <i class="bi bi-calendar-check"></i> Last Updated
                </div>
                <div class="info-value">
                  <?php echo date('F d, Y', strtotime($issue['updated_at'])); ?><br>
                  <small class="text-muted"><?php echo date('h:i A', strtotime($issue['updated_at'])); ?></small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between">
          <a href="index.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
          </a>
          <div>
            <a href="index.php?action=edit&id=<?php echo $issue['id']; ?>" class="btn btn-warning">
              <i class="bi bi-pencil"></i> Edit Issue
            </a>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
              <i class="bi bi-trash"></i> Delete Issue
            </button>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <!-- Image Card -->
        <?php if ($issue['image']): ?>
          <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
              <h6 class="mb-0"><i class="bi bi-image"></i> Attached Image</h6>
            </div>
            <div class="card-body p-0">
              <img src="uploads/<?php echo htmlspecialchars($issue['image']); ?>"
                alt="Issue Image"
                class="img-fluid w-100"
                data-bs-toggle="modal"
                data-bs-target="#imageModal"
                style="cursor: pointer;">
            </div>
            <div class="card-footer text-center">
              <small class="text-muted">
                <i class="bi bi-info-circle"></i> Click image to view full size
              </small>
            </div>
          </div>
        <?php else: ?>
          <div class="card shadow-sm mb-4">
            <div class="card-body text-center py-5">
              <i class="bi bi-image" style="font-size: 4rem; color: #ddd;"></i>
              <p class="text-muted mt-3">No image attached</p>
            </div>
          </div>
        <?php endif; ?>

        <!-- Update Status Card -->
        <div class="card shadow-sm status-update-card">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-gear-fill"></i> Update Status
            </h5>
            <p class="card-text">Change the current status of this issue</p>
            <form method="POST" action="index.php?action=updateStatus" id="statusForm">
              <input type="hidden" name="id" value="<?php echo $issue['id']; ?>">
              <input type="hidden" name="redirect" value="show">

              <div class="mb-3">
                <label class="form-label">Current Status</label>
                <select class="form-select form-select-lg" name="status" id="statusSelect" required>
                  <option value="Pending" <?php echo $issue['status'] == 'Pending' ? 'selected' : ''; ?>>
                    🕐 Pending
                  </option>
                  <option value="In Progress" <?php echo $issue['status'] == 'In Progress' ? 'selected' : ''; ?>>
                    ⚙️ In Progress
                  </option>
                  <option value="Completed" <?php echo $issue['status'] == 'Completed' ? 'selected' : ''; ?>>
                    ✅ Completed
                  </option>
                </select>
              </div>

              <button type="submit" class="btn btn-light w-100">
                <i class="bi bi-check-circle"></i> Update Status
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Image Modal -->
  <?php if ($issue['image']): ?>
    <div class="modal fade" id="imageModal" tabindex="-1">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Issue Image - Full Size</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center p-0">
            <img src="uploads/<?php echo htmlspecialchars($issue['image']); ?>"
              alt="Issue Image"
              class="img-fluid w-100">
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1">
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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- NEW: Auto-dismiss script -->
  <script>
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

  <!-- Custom JavaScript Files -->
  <script src="js/status.js"></script>
  <script src="js/feedbacks.js"></script>
</body>

</html>