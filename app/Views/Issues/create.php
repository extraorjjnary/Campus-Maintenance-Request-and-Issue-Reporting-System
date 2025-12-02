<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report New Issue - Campus Maintenance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

  <style>
    /* Minimal custom CSS */
    .navbar-gradient {
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }

    .required::after {
      content: " *";
      color: #dc3545;
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
        <i class="bi bi-plus-circle me-2"></i>Report New Issue
      </span>
    </div>
  </nav>

  <div class="container mt-4 mb-5">
    <!-- Alert Messages -->
    <?php if (isset($_SESSION['errors'])): ?>
      <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm border-start border-danger border-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Validation Errors:</strong>
        <ul class="mb-0 mt-2">
          <?php foreach ($_SESSION['errors'] as $error): ?>
            <li><?php echo $error; ?></li>
          <?php endforeach; ?>
        </ul>
        <?php unset($_SESSION['errors']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow border-0 rounded-4">
          <div class="card-header bg-primary text-white border-0 p-4">
            <h4 class="mb-1 fw-bold">
              <i class="bi bi-plus-circle me-2"></i>Report New Maintenance Issue
            </h4>
            <p class="mb-0 opacity-90">Fill out the form below to submit a maintenance request</p>
          </div>
          <div class="card-body p-4 p-md-5">
            <form method="POST" action="index.php?action=store" enctype="multipart/form-data" id="issueForm">

              <!-- User Information Section -->
              <h5 class="border-bottom border-2 pb-3 mb-4 text-dark fw-bold">
                <i class="bi bi-person-badge text-primary me-2"></i>Reporter Information
              </h5>

              <div class="row g-3">
                <div class="col-md-6">
                  <label for="user_role" class="form-label fw-semibold required">User Role</label>
                  <select class="form-select form-select-lg rounded-3" id="user_role" name="user_role" required>
                    <option value="">Select Your Role</option>
                    <option value="Student" <?php echo (isset($_SESSION['old_data']['user_role']) && $_SESSION['old_data']['user_role'] == 'Student') ? 'selected' : ''; ?>>Student</option>
                    <option value="Staff" <?php echo (isset($_SESSION['old_data']['user_role']) && $_SESSION['old_data']['user_role'] == 'Staff') ? 'selected' : ''; ?>>Staff</option>
                    <option value="Instructor" <?php echo (isset($_SESSION['old_data']['user_role']) && $_SESSION['old_data']['user_role'] == 'Instructor') ? 'selected' : ''; ?>>Instructor</option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="user_id" class="form-label fw-semibold required">User ID</label>
                  <input type="text" class="form-control form-control-lg rounded-3" id="user_id" name="user_id"
                    placeholder="Enter your ID"
                    value="<?php echo isset($_SESSION['old_data']['user_id']) ? htmlspecialchars($_SESSION['old_data']['user_id']) : ''; ?>"
                    required>
                  <small id="userIdHelp" class="form-text text-muted">
                    <i class="bi bi-info-circle"></i> Please select your role first
                  </small>
                  <div id="userIdError" class="invalid-feedback"></div>
                </div>
              </div>

              <!-- Issue Information Section -->
              <h5 class="border-bottom border-2 pb-3 mb-4 mt-5 text-dark fw-bold">
                <i class="bi bi-clipboard-data text-primary me-2"></i>Issue Details
              </h5>

              <div class="mb-4">
                <label for="title" class="form-label fw-semibold required">Issue Title</label>
                <input type="text" class="form-control form-control-lg rounded-3" id="title" name="title"
                  placeholder="Brief description (e.g., Broken Window in Classroom)"
                  value="<?php echo isset($_SESSION['old_data']['title']) ? htmlspecialchars($_SESSION['old_data']['title']) : ''; ?>"
                  required>
              </div>

              <div class="mb-4">
                <label for="description" class="form-label fw-semibold required">Detailed Description</label>
                <textarea class="form-control form-control-lg rounded-3" id="description" name="description"
                  rows="5"
                  placeholder="Provide detailed information about the issue, including when you noticed it and any safety concerns"
                  required><?php echo isset($_SESSION['old_data']['description']) ? htmlspecialchars($_SESSION['old_data']['description']) : ''; ?></textarea>
                <small class="form-text text-muted">
                  Be as specific as possible to help maintenance team address the issue
                </small>
              </div>

              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label for="category" class="form-label fw-semibold required">Category</label>
                  <select class="form-select form-select-lg rounded-3" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="Plumbing" <?php echo (isset($_SESSION['old_data']['category']) && $_SESSION['old_data']['category'] == 'Plumbing') ? 'selected' : ''; ?>>Plumbing</option>
                    <option value="Electrical" <?php echo (isset($_SESSION['old_data']['category']) && $_SESSION['old_data']['category'] == 'Electrical') ? 'selected' : ''; ?>>Electrical</option>
                    <option value="Infrastructure" <?php echo (isset($_SESSION['old_data']['category']) && $_SESSION['old_data']['category'] == 'Infrastructure') ? 'selected' : ''; ?>>Infrastructure</option>
                    <option value="HVAC" <?php echo (isset($_SESSION['old_data']['category']) && $_SESSION['old_data']['category'] == 'HVAC') ? 'selected' : ''; ?>>HVAC (Heating/Cooling)</option>
                    <option value="Equipment" <?php echo (isset($_SESSION['old_data']['category']) && $_SESSION['old_data']['category'] == 'Equipment') ? 'selected' : ''; ?>>Equipment</option>
                    <option value="Furniture" <?php echo (isset($_SESSION['old_data']['category']) && $_SESSION['old_data']['category'] == 'Furniture') ? 'selected' : ''; ?>>Furniture</option>
                    <option value="Landscaping" <?php echo (isset($_SESSION['old_data']['category']) && $_SESSION['old_data']['category'] == 'Landscaping') ? 'selected' : ''; ?>>Landscaping</option>
                    <option value="Other" <?php echo (isset($_SESSION['old_data']['category']) && $_SESSION['old_data']['category'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="location" class="form-label fw-semibold required">Location</label>
                  <input type="text" class="form-control form-control-lg rounded-3" id="location" name="location"
                    placeholder="e.g., Building A - Room 301"
                    value="<?php echo isset($_SESSION['old_data']['location']) ? htmlspecialchars($_SESSION['old_data']['location']) : ''; ?>"
                    required>
                  <small class="form-text text-muted">Specify building, floor, and room number</small>
                </div>
              </div>

              <div class="mb-4">
                <label for="image" class="form-label fw-semibold">
                  <i class="bi bi-cloud-upload me-2"></i>Upload Image (Optional)
                </label>
                <input type="file" class="form-control form-control-lg rounded-3" id="image" name="image"
                  accept="image/jpeg,image/png,image/jpg">
                <small class="form-text text-muted">
                  <i class="bi bi-info-circle"></i> Max size: 5MB. Formats: JPG, PNG. Images help maintenance team better understand the issue.
                </small>
              </div>

              <div class="mb-4" id="imagePreview" style="display: none;">
                <label class="form-label fw-semibold">Image Preview</label>
                <div class="border rounded-3 p-3 bg-light">
                  <img id="preview" src="" alt="Preview" class="img-fluid rounded-3 shadow-sm" style="max-width: 400px;">
                  <button type="button" class="btn btn-danger btn-sm mt-3 rounded-3" onclick="clearImage()">
                    <i class="bi bi-x me-1"></i>Remove Image
                  </button>
                </div>
              </div>

              <div class="alert alert-info border-0 border-start border-primary border-4 bg-primary bg-opacity-10">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Note:</strong> All reported issues will be reviewed by the maintenance team.
                You can check the status of your report anytime on the main page.
              </div>

              <div class="d-flex justify-content-between flex-wrap gap-3 mt-4 pt-3 border-top">
                <a href="index.php" class="btn btn-secondary btn-lg rounded-3 px-4">
                  <i class="bi bi-arrow-left me-2"></i>Back to List
                </a>
                <button type="submit" class="btn btn-primary btn-lg rounded-3 px-4 shadow-sm" id="submitBtn">
                  <i class="bi bi-send me-2"></i>Submit Issue Report
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JavaScript Files -->
  <script src="js/validation.js"></script>
  <script src="js/preview.js"></script>
  <script src="js/alerts.js"></script>

  <?php
  if (isset($_SESSION['old_data'])) {
    unset($_SESSION['old_data']);
  }
  ?>
</body>

</html>