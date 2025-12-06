<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Issue #<?php echo $issue['id']; ?> - Campus Maintenance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

  <style>
    body {
      background: linear-gradient(to bottom, #e0e7ff 0%, #f3f4f6 100%);
    }

    .navbar-gradient {
      background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
    }

    .status-card-gradient {
      background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
    }
  </style>
</head>

<body class="min-vh-100">
  <!-- Enhanced Professional Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-gradient shadow-lg py-3">
    <div class="container-fluid px-4">
      <!-- Brand Section with Logo -->
      <a class="navbar-brand d-flex align-items-center gap-3 text-decoration-none" href="index.php">
        <!-- Logo Badge -->
        <div class="bg-white rounded-3 p-2 shadow-sm" style="width: 48px; height: 48px;">
          <i class="bi bi-tools text-primary fs-3 d-flex align-items-center justify-content-center"></i>
        </div>

        <!-- Brand Text -->
        <div class="d-none d-lg-block">
          <div class="fw-bold fs-4 lh-1 mb-1" style="letter-spacing: -0.5px;">
            Campus Maintenance & Issue Reporting
          </div>
          <small class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 1.5px;">
            Comprehensive Campus Management System
          </small>
        </div>

        <!-- Compact for smaller screens -->
        <div class="d-lg-none">
          <div class="fw-bold fs-5">Campus Maintenance</div>
        </div>
      </a>

      <!-- Right Side Actions -->
      <div class="d-flex align-items-center gap-2 gap-md-3">
        <div class="d-none d-md-flex align-items-center gap-2 text-white bg-white bg-opacity-10 rounded-pill px-3 py-2">
          <i class="bi bi-eye"></i>
          <span class="fw-semibold small">Issue Details</span>
        </div>

        <div class="vr bg-white opacity-25 d-none d-md-block" style="height: 30px;"></div>

        <div class="dropdown">
          <button class="btn btn-light rounded-pill px-3 fw-semibold dropdown-toggle"
            type="button"
            id="adminDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="bi bi-person-circle me-1"></i>
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

        <a href="index.php" class="btn btn-secondary fw-semibold rounded-pill px-3 px-md-4 shadow-sm">
          <i class="bi bi-arrow-left me-1"></i>
          <span class="d-none d-sm-inline">Dashboard</span>
        </a>
      </div>
    </div>
  </nav>

  <div class="container mt-4 mb-5">
    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show border-0 shadow border-start border-success border-5 bg-white" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong><?php echo $_SESSION['success'];
                unset($_SESSION['success']); ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['errors'])): ?>
      <div class="alert alert-danger alert-dismissible fade show border-0 shadow border-start border-danger border-5 bg-white" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong><?php echo implode('<br>', $_SESSION['errors']);
                unset($_SESSION['errors']); ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-lg-8">
        <div class="card shadow border-0 rounded-4 mb-4 bg-white">
          <div class="card-header bg-primary text-white border-0 p-4 rounded-top-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
              <h4 class="mb-0 fw-bold">
                <i class="bi bi-file-earmark-text me-2"></i>Issue #<?php echo $issue['id']; ?>
              </h4>
              <?php
              $statusClass = '';
              $statusIcon = '';
              switch ($issue['status']) {
                case 'Pending':
                  $statusClass = 'bg-warning text-dark';
                  $statusIcon = '⏳';
                  break;
                case 'In Progress':
                  $statusClass = 'bg-info text-white';
                  $statusIcon = '⚙️';
                  break;
                case 'Completed':
                  $statusClass = 'bg-success text-white';
                  $statusIcon = '✅';
                  break;
              }
              ?>
              <span class="badge <?php echo $statusClass; ?> fs-6 px-3 py-2 rounded-pill shadow-sm">
                <?php echo $statusIcon; ?> <?php echo $issue['status']; ?>
              </span>
            </div>
          </div>
          <div class="card-body p-4 p-md-5">
            <!-- Issue Title -->
            <h3 class="mb-4 fw-bold text-dark border-bottom border-2 border-primary border-opacity-25 pb-3">
              <?php echo htmlspecialchars($issue['title']); ?>
            </h3>

            <!-- Reporter Information -->
            <div class="row mb-4">
              <div class="col-md-6 mb-3 mb-md-0">
                <p class="text-uppercase fw-bold text-secondary small mb-2">
                  <i class="bi bi-person-badge text-primary me-1"></i>Reported By
                </p>
                <p class="fs-5 mb-0">
                  <code class="bg-light px-3 py-2 rounded-3 text-primary fw-bold fs-6"><?php echo htmlspecialchars($issue['user_id']); ?></code>
                </p>
              </div>
              <div class="col-md-6">
                <p class="text-uppercase fw-bold text-secondary small mb-2">
                  <i class="bi bi-person text-primary me-1"></i>User Role
                </p>
                <p class="fs-5 mb-0">
                  <span class="badge bg-secondary fs-6 px-3 py-2 rounded-pill">
                    <?php echo htmlspecialchars($issue['user_role']); ?>
                  </span>
                </p>
              </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
              <p class="text-uppercase fw-bold text-secondary small mb-2">
                <i class="bi bi-card-text text-primary me-1"></i>Description
              </p>
              <div class="bg-light border-start border-primary border-4 p-4 rounded-3">
                <p class="mb-0 lh-lg text-dark"><?php echo nl2br(htmlspecialchars($issue['description'])); ?></p>
              </div>
            </div>

            <!-- Issue Details -->
            <div class="row mb-4">
              <div class="col-md-6 mb-3 mb-md-0">
                <p class="text-uppercase fw-bold text-secondary small mb-2">
                  <i class="bi bi-tag text-primary me-1"></i>Category
                </p>
                <p class="fs-5 mb-0">
                  <span class="badge bg-secondary fs-6 px-3 py-2 rounded-pill">
                    <?php echo htmlspecialchars($issue['category']); ?>
                  </span>
                </p>
              </div>
              <div class="col-md-6">
                <p class="text-uppercase fw-bold text-secondary small mb-2">
                  <i class="bi bi-geo-alt text-primary me-1"></i>Location
                </p>
                <p class="fs-5 mb-0 text-dark"><?php echo htmlspecialchars($issue['location']); ?></p>
              </div>
            </div>

            <!-- Timestamps -->
            <div class="row bg-light rounded-3 p-3">
              <div class="col-md-6 mb-3 mb-md-0">
                <p class="text-uppercase fw-bold text-secondary small mb-2">
                  <i class="bi bi-calendar-plus text-primary me-1"></i>Created At
                </p>
                <p class="mb-0 fw-semibold text-dark">
                  <?php echo date('F d, Y', strtotime($issue['created_at'])); ?>
                  <small class="text-muted d-block"><?php echo date('h:i A', strtotime($issue['created_at'])); ?></small>
                </p>
              </div>
              <div class="col-md-6">
                <p class="text-uppercase fw-bold text-secondary small mb-2">
                  <i class="bi bi-calendar-check text-primary me-1"></i>Last Updated
                </p>
                <p class="mb-0 fw-semibold text-dark">
                  <?php echo date('F d, Y', strtotime($issue['updated_at'])); ?>
                  <small class="text-muted d-block"><?php echo date('h:i A', strtotime($issue['updated_at'])); ?></small>
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between flex-wrap gap-2">
          <a href="index.php" class="btn btn-secondary btn-lg rounded-pill px-4 shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
          </a>
          <div class="d-flex gap-2 flex-wrap">
            <a href="index.php?action=edit&id=<?php echo $issue['id']; ?>" class="btn btn-warning btn-lg rounded-pill px-4 shadow-sm">
              <i class="bi bi-pencil me-2"></i>Edit
            </a>
            <button type="button" class="btn btn-danger btn-lg rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
              <i class="bi bi-trash me-2"></i>Delete
            </button>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mt-4 mt-lg-0">
        <!-- Image Card -->
        <?php if ($issue['image']): ?>
          <div class="card shadow border-0 rounded-4 mb-4 bg-white">
            <div class="card-header bg-dark text-white border-0 p-3 rounded-top-4">
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
            <div class="card-footer text-center bg-light border-0 rounded-bottom-4 py-3">
              <small class="text-muted fw-semibold">
                <i class="bi bi-zoom-in me-1"></i>Click to enlarge
              </small>
            </div>
          </div>
        <?php else: ?>
          <div class="card shadow border-0 rounded-4 mb-4 bg-white">
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
            <p class="mb-4 opacity-90 small">Change the current status of this issue</p>
            <form method="POST" action="index.php?action=updateStatus" id="statusForm">
              <input type="hidden" name="id" value="<?php echo $issue['id']; ?>">
              <input type="hidden" name="redirect" value="show">

              <div class="mb-3">
                <label class="form-label fw-semibold">Current Status</label>
                <select class="form-select form-select-lg rounded-3 bg-white text-dark border-2"
                  name="status"
                  id="statusSelect"
                  data-current="<?php echo $issue['status']; ?>"
                  required>
                  <option value="Pending" <?php echo $issue['status'] == 'Pending' ? 'selected' : ''; ?>>
                    ⏳ Pending
                  </option>
                  <option value="In Progress" <?php echo $issue['status'] == 'In Progress' ? 'selected' : ''; ?>>
                    ⚙️ In Progress
                  </option>
                  <option value="Completed" <?php echo $issue['status'] == 'Completed' ? 'selected' : ''; ?>>
                    ✅ Completed
                  </option>
                </select>
              </div>

              <button type="submit" class="btn btn-light btn-lg w-100 rounded-pill fw-bold shadow-sm">
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
        <div class="modal-content border-0 shadow-lg rounded-4">
          <div class="modal-header border-0 rounded-top-4">
            <h5 class="modal-title fw-bold">
              <i class="bi bi-zoom-in me-2"></i>Issue Image - Full Size
            </h5>
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
            <strong class="d-block mb-1">Issue #<?php echo $issue['id']; ?>:</strong>
            <span class="text-dark"><?php echo htmlspecialchars($issue['title']); ?></span>
          </div>
          <p class="text-danger fw-bold mb-0">
            <i class="bi bi-exclamation-circle me-1"></i>This action cannot be undone!
          </p>
        </div>
        <div class="modal-footer border-0 bg-light rounded-bottom-4">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
            <i class="bi bi-x me-1"></i>Cancel
          </button>
          <form method="POST" action="index.php?action=delete" class="d-inline">
            <input type="hidden" name="id" value="<?php echo $issue['id']; ?>">
            <button type="submit" class="btn btn-danger rounded-pill px-4">
              <i class="bi bi-trash me-2"></i>Delete Issue
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Status Update Confirmation Modal -->
  <div class="modal fade" id="statusConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4">
        <div class="modal-header bg-primary text-white border-0 rounded-top-4">
          <h5 class="modal-title fw-bold">
            <i class="bi bi-question-circle-fill me-2"></i>Confirm Status Update
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <p class="mb-3">Are you sure you want to update the status?</p>
          <div class="alert alert-info border-0 bg-info bg-opacity-10 border-start border-info border-4 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="fw-semibold">Current Status:</span>
              <span id="currentStatusBadge" class="badge bg-secondary px-3 py-2"></span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="fw-semibold">New Status:</span>
              <span id="newStatusBadge" class="badge bg-primary px-3 py-2"></span>
            </div>
          </div>
          <p class="text-muted small mb-0">
            <i class="bi bi-info-circle me-1"></i>This will update the issue status and notify relevant parties.
          </p>
        </div>
        <div class="modal-footer border-0 bg-light rounded-bottom-4">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
            <i class="bi bi-x me-1"></i>Cancel
          </button>
          <button type="button" class="btn btn-primary rounded-pill px-4" id="confirmStatusUpdate">
            <i class="bi bi-check-circle me-2"></i>Confirm Update
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JavaScript Files -->
  <script src="js/alerts.js"></script>
  <script src="js/status-update.js"></script>

</body>

</html>