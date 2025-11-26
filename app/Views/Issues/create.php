<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report New Issue - Campus Maintenance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    .id-format-help {
      font-size: 0.875rem;
      margin-top: 5px;
    }

    .invalid-feedback {
      display: block;
    }

    .form-label.required::after {
      content: " *";
      color: red;
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
        Report New Issue
      </span>
    </div>
  </nav>

  <div class="container mt-4">
    <!-- Alert Messages -->
    <?php if (isset($_SESSION['errors'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> <strong>Validation Errors:</strong>
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
      <div class="col-md-10">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Report New Maintenance Issue</h4>
            <small>Fill out the form below to submit a maintenance request</small>
          </div>
          <div class="card-body">
            <form method="POST" action="index.php?action=store" enctype="multipart/form-data" id="issueForm">

              <!-- User Information Section -->
              <h5 class="border-bottom pb-2 mb-3"><i class="bi bi-person-badge"></i> Reporter Information</h5>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="user_role" class="form-label required">User Role</label>
                  <select class="form-select" id="user_role" name="user_role" required>
                    <option value="">Select Your Role</option>
                    <option value="Student" <?php echo (isset($_SESSION['old_data']['user_role']) && $_SESSION['old_data']['user_role'] == 'Student') ? 'selected' : ''; ?>>Student</option>
                    <option value="Staff" <?php echo (isset($_SESSION['old_data']['user_role']) && $_SESSION['old_data']['user_role'] == 'Staff') ? 'selected' : ''; ?>>Staff</option>
                    <option value="Instructor" <?php echo (isset($_SESSION['old_data']['user_role']) && $_SESSION['old_data']['user_role'] == 'Instructor') ? 'selected' : ''; ?>>Instructor</option>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="user_id" class="form-label required">User ID</label>
                  <input type="text" class="form-control" id="user_id" name="user_id"
                    placeholder="Enter your ID"
                    value="<?php echo isset($_SESSION['old_data']['user_id']) ? htmlspecialchars($_SESSION['old_data']['user_id']) : ''; ?>"
                    required>
                  <div id="userIdHelp" class="id-format-help text-muted">
                    <i class="bi bi-info-circle"></i> Please select your role first
                  </div>
                  <div id="userIdError" class="invalid-feedback" style="display: none;"></div>
                </div>
              </div>

              <!-- Issue Information Section -->
              <h5 class="border-bottom pb-2 mb-3 mt-4"><i class="bi bi-clipboard-data"></i> Issue Details</h5>

              <div class="mb-3">
                <label for="title" class="form-label required">Issue Title</label>
                <input type="text" class="form-control" id="title" name="title"
                  placeholder="Brief description of the issue (e.g., Broken Window in Classroom)"
                  value="<?php echo isset($_SESSION['old_data']['title']) ? htmlspecialchars($_SESSION['old_data']['title']) : ''; ?>"
                  required>
              </div>

              <div class="mb-3">
                <label for="description" class="form-label required">Detailed Description</label>
                <textarea class="form-control" id="description" name="description"
                  rows="4"
                  placeholder="Provide detailed information about the issue, including when you noticed it and any safety concerns"
                  required><?php echo isset($_SESSION['old_data']['description']) ? htmlspecialchars($_SESSION['old_data']['description']) : ''; ?></textarea>
                <small class="text-muted">Be as specific as possible to help maintenance team address the issue</small>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="category" class="form-label required">Category</label>
                  <select class="form-select" id="category" name="category" required>
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

                <div class="col-md-6 mb-3">
                  <label for="location" class="form-label required">Location</label>
                  <input type="text" class="form-control" id="location" name="location"
                    placeholder="e.g., Building A - Room 301"
                    value="<?php echo isset($_SESSION['old_data']['location']) ? htmlspecialchars($_SESSION['old_data']['location']) : ''; ?>"
                    required>
                  <small class="text-muted">Specify building, floor, and room number</small>
                </div>
              </div>

              <div class="mb-3">
                <label for="image" class="form-label">Upload Image (Optional)</label>
                <input type="file" class="form-control" id="image" name="image"
                  accept="image/jpeg,image/png,image/jpg">
                <small class="form-text text-muted">
                  <i class="bi bi-info-circle"></i> Max size: 5MB. Formats: JPG, PNG.
                  Images help maintenance team better understand the issue.
                </small>
              </div>

              <div class="mb-3" id="imagePreview" style="display: none;">
                <label class="form-label">Image Preview</label>
                <div>
                  <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 400px;">
                  <button type="button" class="btn btn-sm btn-danger mt-2" onclick="clearImage()">
                    <i class="bi bi-x"></i> Remove Image
                  </button>
                </div>
              </div>

              <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>Note:</strong> All reported issues will be reviewed by the maintenance team.
                You can check the status of your report anytime on the main page.
              </div>

              <div class="d-flex justify-content-between mt-4">
                <a href="index.php" class="btn btn-secondary">
                  <i class="bi bi-arrow-left"></i> Back to List
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                  <i class="bi bi-send"></i> Submit Issue Report
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // User ID Validation with Native JavaScript
    const userRoleSelect = document.getElementById('user_role');
    const userIdInput = document.getElementById('user_id');
    const userIdHelp = document.getElementById('userIdHelp');
    const userIdError = document.getElementById('userIdError');
    const issueForm = document.getElementById('issueForm');
    const submitBtn = document.getElementById('submitBtn');

    // ID Format patterns
    const patterns = {
      'Student': /^[0-9]{2}-[0-9]{4}$/,
      'Staff': /^EMP-[0-9]{4}$/,
      'Instructor': /^EMP-[0-9]{4}$/
    };

    // Update help text based on selected role
    userRoleSelect.addEventListener('change', function() {
      const role = this.value;
      userIdInput.value = ''; // Clear previous input
      userIdError.style.display = 'none';
      userIdInput.classList.remove('is-invalid', 'is-valid');

      if (role === 'Student') {
        userIdHelp.innerHTML = '<i class="bi bi-info-circle"></i> Format: <strong>YY-XXXX</strong> (e.g., 23-4302)';
        userIdInput.placeholder = 'e.g., 23-4302';
      } else if (role === 'Staff' || role === 'Instructor') {
        userIdHelp.innerHTML = '<i class="bi bi-info-circle"></i> Format: <strong>EMP-XXXX</strong> (e.g., EMP-2043)';
        userIdInput.placeholder = 'e.g., EMP-2043';
      } else {
        userIdHelp.innerHTML = '<i class="bi bi-info-circle"></i> Please select your role first';
        userIdInput.placeholder = 'Enter your ID';
      }
    });

    // Real-time validation on input
    userIdInput.addEventListener('input', function() {
      validateUserId();
    });

    // Validation function
    function validateUserId() {
      const role = userRoleSelect.value;
      const userId = userIdInput.value.trim();

      if (!role) {
        userIdError.textContent = 'Please select your role first';
        userIdError.style.display = 'block';
        userIdInput.classList.add('is-invalid');
        userIdInput.classList.remove('is-valid');
        return false;
      }

      if (!userId) {
        userIdError.style.display = 'none';
        userIdInput.classList.remove('is-invalid', 'is-valid');
        return false;
      }

      const pattern = patterns[role];
      if (!pattern.test(userId)) {
        let formatMessage = '';
        if (role === 'Student') {
          formatMessage = 'Student ID must be in format: YY-XXXX (e.g., 23-4302)';
        } else {
          formatMessage = 'Staff/Instructor ID must be in format: EMP-XXXX (e.g., EMP-2043)';
        }
        userIdError.textContent = formatMessage;
        userIdError.style.display = 'block';
        userIdInput.classList.add('is-invalid');
        userIdInput.classList.remove('is-valid');
        return false;
      } else {
        userIdError.style.display = 'none';
        userIdInput.classList.remove('is-invalid');
        userIdInput.classList.add('is-valid');
        return true;
      }
    }

    // Form submission validation
    issueForm.addEventListener('submit', function(e) {
      const title = document.getElementById('title').value.trim();
      const description = document.getElementById('description').value.trim();
      const category = document.getElementById('category').value;
      const location = document.getElementById('location').value.trim();
      const role = userRoleSelect.value;

      // Check if User ID is valid
      if (!validateUserId()) {
        e.preventDefault();
        alert('Please enter a valid User ID for your selected role');
        userIdInput.focus();
        return false;
      }

      // Check other required fields
      if (!title || !description || !category || !location || !role) {
        e.preventDefault();
        alert('Please fill in all required fields');
        return false;
      }

      // Show loading state
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Submitting...';
    });

    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        // Check file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
          alert('Image size must be less than 5MB');
          this.value = '';
          return;
        }

        // Check file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
          alert('Only JPG and PNG images are allowed');
          this.value = '';
          return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('preview').src = e.target.result;
          document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        document.getElementById('imagePreview').style.display = 'none';
      }
    });

    // Clear image function
    function clearImage() {
      document.getElementById('image').value = '';
      document.getElementById('imagePreview').style.display = 'none';
    }

    <?php
    // Clear old data after displaying
    if (isset($_SESSION['old_data'])) {
      unset($_SESSION['old_data']);
    }
    ?>
  </script>
</body>

</html>