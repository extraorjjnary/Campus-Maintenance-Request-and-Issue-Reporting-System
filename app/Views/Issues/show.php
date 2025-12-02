<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Issue #<?php echo $issue['id']; ?> - Campus Maintenance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

  <style>
    /* Minimal custom CSS */
    .navbar-gradient {
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }

    .status-card-gradient {
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }
  </style>
</head>

<body class="bg-light">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-gradient shadow-sm">
    <div class="container-fluid px-4">
      <a class="navbar-brand fw-bold fs-4" href="index.php">
        <i class="bi bi-tools me-2"></i>Campus Maintenance
      </a>
      <span class="navbar-text text-white">
        <i class="bi bi-eye me-2"></i>Issue Details
      </span>
    </div>
  </nav>

  <div class="container mt-4 mb-5">
    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm border-start border-success border-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong><?php echo $_SESSION['success'];
                unset($_SESSION['success']); ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['errors'])): ?>
      <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm border-start border-danger border-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong><?php echo implode('<br>', $_SESSION['errors']);
                unset($_SESSION['errors']); ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-lg-8">
        <div class="card shadow border-0 rounded-4 mb-4">
          <div class="card-header bg-primary text-white border-0 p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
              <h4 class="mb-0 fw-bold">
                <i class="bi bi-eye me-2"></i>Issue #<?php echo $issue['id']; ?>
              </h4>
              <?php
              $statusClass = '';
              switch ($issue['status']) {
                case 'Pending':
                  $statusClass = 'bg-warning text-dark';
                  break;
                case 'In Progress':
                  $statusClass = 'bg-info text-white';
                  break;
                case 'Completed':
                  $statusClass = 'bg-success text-white';
                  break;
              }
              ?>
              <span class="badge <?php echo $statusClass; ?> fs-6 px-3 py-2 rounded-pill">
                <?php echo $issue['status']; ?>
              </span>
            </div>
          </div>
          <div class="card-body p-4 p-md-5">
            <!-- Issue Title -->
            <h3 class="mb-4 fw-bold text-dark"><?php echo htmlspecialchars($issue['title']); ?></h3>

            <!-- Reporter Information -->
            <div class="row mb-4">
              <div class="col-md-6 mb-3 mb-md-0">
                <p class="text-uppercase fw-bold text-secondary small mb-2">
                  <i class="bi bi-person-badge me-1"></i>Reported By
                </p>
                <p class="fs-5 mb-0">
                  <code class="bg-light px-3 py-2 rounded-3 text-primary fw-bold"><?php echo htmlspecialchars($issue['user_id']); ?></code>
                </p>
              </div>
              <div class="col-md-6">
                <p class="text-uppercase fw-bold text-secondary small mb-2">
                  <i class="bi bi-person me-1"></i>User Role
                </p>
                <p class="fs-5 mb-0">
                  <span class="badge bg-secondary fs-6 px-3 py-2">
                    <?php echo htmlspecialchars($issue['user_role']); ?>
                  </span>
                </p>
              </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
              <p class="text-uppercase fw-bold text-secondary small mb-2">
                <i class="bi bi-card-text me-1"></i>Description
              </p>
              <div class="bg-light border-start border-primary border-4 p-4 rounded-3">
                <p class="mb-0 lh-lg"><?php echo nl2br(htmlspecialchars($issue['description'])); ?></p>
              </div>
            </div>

            <!-- Issue Details -->
            <div class="row mb-4">
              <div class="col-md-6 mb-3 mb-md-0">
                <p class="text-uppercase fw-bold text-secondary small mb-2">
                  <i class="bi bi-tag me-1"></i>Category
                </p>
                <p class="fs-5 mb-0">
                  <span class="badge bg-secondary fs-6 px-3 py-2">
                    <?php echo htmlspecialchars($issue['category']); ?>
                  </span>
                </p>
              </div>
              <div class="col-md-6">
                <p class="text-uppercase fw-bold text-secondary small mb-2">
                  <i class="bi bi-geo-alt me-1"></i>Location
                </p>
                <p class="fs-5 mb-0"><?php echo htmlspecialchars($issue['location']); ?></p>
              </div>
            </div>

            <!-- Timestamps -->
            <div class="row">
              <div class="col-md-6 mb-3 mb-md-0">
                <p class="text-uppercase fw-bold text-secondary small mb-2">
                  <i class="bi bi-calendar-plus me-1"></i>Created At
                </p>
                <p class="mb-0">
                  <?php echo date('F d, Y', strtotime($issue['created_at'])); ?>
                  <small class="text-muted d-block"><?php echo date('h:i A', strtotime($issue['created_at'])); ?></small>
                </p>
              </div>
              <div class="col-md-6">
                <p class="text-uppercase fw-bold text-secondary small mb-2">
                  <i class="bi bi-calendar-check me-1"></i>Last Updated
                </p>
                <p class="mb-0">
                  <?php echo date('F d, Y', strtotime($issue['updated_at'])); ?>
                  <small class="text-muted d-block"><?php echo date('h:i A', strtotime($issue['updated_at'])); ?></small>
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between flex-wrap gap-2">
          <a href="index.php" class="btn btn-secondary btn-lg rounded-3">
            <i class="bi bi-arrow-left me-2"></i>Back to List
          </a>
          <div class="d-flex gap-2 flex-wrap">
            <a href="index.php?action=edit&id=<?php echo $issue['id']; ?>" class="btn btn-warning btn-lg rounded-3">
              <i class="bi bi-pencil me-2"></i>Edit Issue
            </a>
            <button type="button" class="btn btn-danger btn-lg rounded-3" data-bs-toggle="modal" data-bs-target="#deleteModal">
              <i class="bi bi-trash me-2"></i>Delete
            </button>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mt-4 mt-lg-0">
        <!-- Image Card -->
        <?php if ($issue['image']): ?>
          <div class="card shadow border-0 rounded-4 mb-4">
            <div class="card-header bg-dark text-white border-0 p-3">
              <h6 class="mb-0 fw-bold"><i class="bi bi-image me-2"></i>Attached Image</h6>
            </div>
            <div class="card-body p-0">
              <img src="uploads/<?php echo htmlspecialchars($issue['image']); ?>"
                alt="Issue Image"
                class="img-fluid w-100"
                style="cursor: pointer;"
                data-bs-toggle="modal"
                data-bs-target="#imageModal">
            </div>
            <div class="card-footer text-center bg-light border-0">
              <small class="text-muted">
                <i class="bi bi-info-circle me-1"></i>Click to view full size
              </small>
            </div>
          </div>
        <?php else: ?>
          <div class="card shadow border-0 rounded-4 mb-4">
            <div class="card-body text-center py-5">
              <i class="bi bi-image display-1 text-muted opacity-25"></i>
              <p class="text-muted mt-3 mb-0 fw-semibold">No image attached</p>
            </div>
          </div>
        <?php endif; ?>

        <!-- Update Status Card -->
        <div class="card text-white border-0 rounded-4 shadow status-card-gradient">
          <div class="card-body p-4">
            <h5 class="fw-bold mb-2">
              <i class="bi bi-gear-fill me-2"></i>Update Status
            </h5>
            <p class="mb-4 opacity-90">Change the current status of this issue</p>
            <form method="POST" action="index.php?action=updateStatus" id="statusForm">
              <input type="hidden" name="id" value="<?php echo $issue['id']; ?>">
              <input type="hidden" name="redirect" value="show">

              <div class="mb-3">
                <label class="form-label fw-semibold">Current Status</label>
                <select class="form-select form-select-lg rounded-3 bg-white" name="status" id="statusSelect" required>
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

              <button type="submit" class="btn btn-light btn-lg w-100 rounded-3 fw-bold">
                <i class="bi bi-check-circle me-2"></i>Update Status
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
        <div class="modal-content border-0 shadow rounded-4">
          <div class="modal-header border-0">
            <h5 class="modal-title fw-bold">Issue Image - Full Size</h5>
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
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow rounded-4">
        <div class="modal-header bg-danger text-white border-0">
          <h5 class="modal-title fw-bold">
            <i class="bi bi-exclamation-triangle me-2"></i>Confirm Delete
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <p>Are you sure you want to delete this issue?</p>
          <div class="alert alert-warning border-0 mb-3">
            <strong>Issue #<?php echo $issue['id']; ?>:</strong><br>
            <?php echo htmlspecialchars($issue['title']); ?>
          </div>
          <p class="text-danger fw-bold mb-0">
            <i class="bi bi-exclamation-circle me-1"></i>This action cannot be undone!
          </p>
        </div>
        <div class="modal-footer border-0 bg-light">
          <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">
            <i class="bi bi-x me-1"></i>Cancel
          </button>
          <form method="POST" action="index.php?action=delete" class="d-inline">
            <input type="hidden" name="id" value="<?php echo $issue['id']; ?>">
            <button type="submit" class="btn btn-danger rounded-3">
              <i class="bi bi-trash me-2"></i>Delete Issue
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JavaScript Files -->
  <script src="js/status.js"></script>
  <script src="js/feedbacks.js"></script>
  <script src="js/alerts.js"></script>

</body>

</html>