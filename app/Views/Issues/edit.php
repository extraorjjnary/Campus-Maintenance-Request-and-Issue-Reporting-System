<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Issue #<?php echo $issue['id']; ?> - Campus Maintenance</title>
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
        Edit Issue
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
          <div class="card-header bg-warning">
            <h4 class="mb-0"><i class="bi bi-pencil"></i> Edit Issue #<?php echo $issue['id']; ?></h4>
            <small>Update the issue information below</small>
          </div>
          <div class="card-body">
            <form method="POST" action="index.php?action=update" enctype="multipart/form-data" id="editForm">
              <input type="hidden" name="id" value="<?php echo $issue['id']; ?>">

              <!-- User Information Section -->
              <h5 class="border-bottom pb-2 mb-3"><i class="bi bi-person-badge"></i> Reporter Information</h5>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="user_role" class="form-label required">User Role</label>
                  <select class="form-select" id="user_role" name="user_role" required>
                    <option value="">Select Role</option>
                    <option value="Student" <?php echo $issue['user_role'] == 'Student' ? 'selected' : ''; ?>>Student</option>
                    <option value="Staff" <?php echo $issue['user_role'] == 'Staff' ? 'selected' : ''; ?>>Staff</option>
                    <option value="Instructor" <?php echo $issue['user_role'] == 'Instructor' ? 'selected' : ''; ?>>Instructor</option>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="user_id" class="form-label required">User ID</label>
                  <input type="text" class="form-control" id="user_id" name="user_id"
                    value="<?php echo htmlspecialchars($issue['user_id']); ?>" required>
                  <div id="userIdHelp" class="id-format-help text-muted"></div>
                  <div id="userIdError" class="invalid-feedback" style="display: none;"></div>
                </div>
              </div>

              <!-- Issue Information Section -->
              <h5 class="border-bottom pb-2 mb-3 mt-4"><i class="bi bi-clipboard-data"></i> Issue Details</h5>

              <div class="mb-3">
                <label for="title" class="form-label required">Issue Title</label>
                <input type="text" class="form-control" id="title" name="title"
                  value="<?php echo htmlspecialchars($issue['title']); ?>" required>
              </div>

              <div class="mb-3">
                <label for="description" class="form-label required">Detailed Description</label>
                <textarea class="form-control" id="description" name="description"
                  rows="4" required><?php echo htmlspecialchars($issue['description']); ?></textarea>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="category" class="form-label required">Category</label>
                  <select class="form-select" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="Plumbing" <?php echo $issue['category'] == 'Plumbing' ? 'selected' : ''; ?>>Plumbing</option>
                    <option value="Electrical" <?php echo $issue['category'] == 'Electrical' ? 'selected' : ''; ?>>Electrical</option>
                    <option value="Infrastructure" <?php echo $issue['category'] == 'Infrastructure' ? 'selected' : ''; ?>>Infrastructure</option>
                    <option value="HVAC" <?php echo $issue['category'] == 'HVAC' ? 'selected' : ''; ?>>HVAC (Heating/Cooling)</option>
                    <option value="Equipment" <?php echo $issue['category'] == 'Equipment' ? 'selected' : ''; ?>>Equipment</option>
                    <option value="Furniture" <?php echo $issue['category'] == 'Furniture' ? 'selected' : ''; ?>>Furniture</option>
                    <option value="Landscaping" <?php echo $issue['category'] == 'Landscaping' ? 'selected' : ''; ?>>Landscaping</option>
                    <option value="Other" <?php echo $issue['category'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="location" class="form-label required">Location</label>
                  <input type="text" class="form-control" id="location" name="location"
                    value="<?php echo htmlspecialchars($issue['location']); ?>" required>
                </div>
              </div>

              <?php if ($issue['image']): ?>
                <div class="mb-3">
                  <label class="form-label">Current Image</label>
                  <div>
                    <img src="uploads/<?php echo htmlspecialchars($issue['image']); ?>"
                      alt="Current Image"
                      class="img-thumbnail"
                      style="max-width: 400px;">
                  </div>
                  <small class="form-text text-muted">
                    <i class="bi bi-info-circle"></i> Upload a new image to replace this one
                  </small>
                </div>
              <?php endif; ?>

              <div class="mb-3">
                <label for="image" class="form-label">
                  <?php echo $issue['image'] ? 'Upload New Image (Optional)' : 'Upload Image (Optional)'; ?>
                </label>
                <input type="file" class="form-control" id="image" name="image"
                  accept="image/jpeg,image/png,image/jpg">
                <small class="form-text text-muted">Max size: 5MB. Formats: JPG, PNG</small>
              </div>

              <div class="mb-3" id="imagePreview" style="display: none;">
                <label class="form-label">New Image Preview</label>
                <div>
                  <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 400px;">
                  <button type="button" class="btn btn-sm btn-danger mt-2" onclick="clearImage()">
                    <i class="bi bi-x"></i> Remove New Image
                  </button>
                </div>
              </div>

              <div class="d-flex justify-content-between mt-4">
                <a href="index.php?action=show&id=<?php echo $issue['id']; ?>" class="btn btn-secondary">
                  <i class="bi bi-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn btn-warning" id="submitBtn">
                  <i class="bi bi-save"></i> Update Issue
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
    const editForm = document.getElementById('editForm');
    const submitBtn = document.getElementById('submitBtn');

    // ID Format patterns
    const patterns = {
      'Student': /^[0-9]{2}-[0-9]{4}$/,
      'Staff': /^EMP-[0-9]{4}$/,
      'Instructor': /^EMP-[0-9]{4}$/
    };

    // Initialize help text on page load
    function updateHelpText() {
      const role = userRoleSelect.value;

      if (role === 'Student') {
        userIdHelp.innerHTML = '<i class="bi bi-info-circle"></i> Format: <strong>YY-XXXX</strong> (e.g., 23-4302)';
      } else if (role === 'Staff' || role === 'Instructor') {
        userIdHelp.innerHTML = '<i class="bi bi-info-circle"></i> Format: <strong>EMP-XXXX</strong> (e.g., EMP-2043)';
      } else {
        userIdHelp.innerHTML = '<i class="bi bi-info-circle"></i> Please select a role';
      }
    }

    // Call on page load
    updateHelpText();

    // Update help text when role changes
    userRoleSelect.addEventListener('change', function() {
      updateHelpText();
      validateUserId();
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
        userIdError.textContent = 'Please select a role first';
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
    editForm.addEventListener('submit', function(e) {
      const title = document.getElementById('title').value.trim();
      const description = document.getElementById('description').value.trim();
      const category = document.getElementById('category').value;
      const location = document.getElementById('location').value.trim();
      const role = userRoleSelect.value;

      // Check if User ID is valid
      if (!validateUserId()) {
        e.preventDefault();
        alert('Please enter a valid User ID for the selected role');
        userIdInput.focus();
        return false;
      }

      // Check other required fields
      if (!title || !description || !category || !location || !role) {
        e.preventDefault();
        alert('Please fill in all required fields');
        return false;
      }

      // Confirm update
      if (!confirm('Are you sure you want to update this issue?')) {
        e.preventDefault();
        return false;
      }

      // Show loading state
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Updating...';
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

    // Clear new image function
    function clearImage() {
      document.getElementById('image').value = '';
      document.getElementById('imagePreview').style.display = 'none';
    }
  </script>
</body>

</html>