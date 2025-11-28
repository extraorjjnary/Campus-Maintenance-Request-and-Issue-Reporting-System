<?php

/**
 * Form Partial - Reusable Issue Form
 * Used by both create.php and edit.php
 * 
 * Expected variables from parent view:
 * - $issue (array) - existing issue data for edit mode (empty array for create)
 * - $action (string) - form action URL (e.g., 'index.php?action=store')
 * - $method (string) - form method (should always be POST)
 * - $isEdit (bool) - true if editing, false if creating
 */

// Set default values for create mode if not provided
$isEdit = $isEdit ?? false;
$issue = $issue ?? [];

/**
 * Helper function: Get old input or existing value
 * Priority: 1) Session old_data (validation errors), 2) Existing issue data (edit), 3) Default value
 * 
 * @param string $field - Field name (e.g., 'title', 'user_id')
 * @param mixed $default - Default value if nothing found
 * @return mixed - The value to display in the form
 */
function old($field, $default = '')
{
  global $issue;

  // Priority 1: Check for old data from validation errors (most recent user input)
  if (isset($_SESSION['old_data'][$field])) {
    return $_SESSION['old_data'][$field];
  }

  // Priority 2: Check for existing issue data (edit mode)
  if (isset($issue[$field])) {
    return $issue[$field];
  }

  // Priority 3: Return default value
  return $default;
}
?>

<form method="<?php echo $method; ?>" action="<?php echo $action; ?>" enctype="multipart/form-data" id="<?php echo $isEdit ? 'editForm' : 'issueForm'; ?>">

  <?php if ($isEdit): ?>
    <!-- Hidden field for issue ID in edit mode -->
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($issue['id']); ?>">
  <?php endif; ?>

  <!-- User Information Section -->
  <h5 class="border-bottom pb-2 mb-3">
    <i class="bi bi-person-badge"></i> Reporter Information
  </h5>

  <div class="row">
    <!-- User Role -->
    <div class="col-md-6 mb-3">
      <label for="user_role" class="form-label required">User Role</label>
      <select class="form-select" id="user_role" name="user_role" required>
        <option value="">Select Your Role</option>
        <option value="Student" <?php echo old('user_role') == 'Student' ? 'selected' : ''; ?>>
          Student
        </option>
        <option value="Staff" <?php echo old('user_role') == 'Staff' ? 'selected' : ''; ?>>
          Staff
        </option>
        <option value="Instructor" <?php echo old('user_role') == 'Instructor' ? 'selected' : ''; ?>>
          Instructor
        </option>
      </select>
    </div>

    <!-- User ID -->
    <div class="col-md-6 mb-3">
      <label for="user_id" class="form-label required">User ID</label>
      <input type="text"
        class="form-control"
        id="user_id"
        name="user_id"
        placeholder="Enter your ID"
        value="<?php echo htmlspecialchars(old('user_id')); ?>"
        required>
      <div id="userIdHelp" class="id-format-help text-muted">
        <i class="bi bi-info-circle"></i> Please select your role first
      </div>
      <div id="userIdError" class="invalid-feedback" style="display: none;"></div>
    </div>
  </div>

  <!-- Issue Information Section -->
  <h5 class="border-bottom pb-2 mb-3 mt-4">
    <i class="bi bi-clipboard-data"></i> Issue Details
  </h5>

  <!-- Issue Title -->
  <div class="mb-3">
    <label for="title" class="form-label required">Issue Title</label>
    <input type="text"
      class="form-control"
      id="title"
      name="title"
      placeholder="Brief description of the issue (e.g., Broken Window in Classroom)"
      value="<?php echo htmlspecialchars(old('title')); ?>"
      required>
  </div>

  <!-- Description -->
  <div class="mb-3">
    <label for="description" class="form-label required">Detailed Description</label>
    <textarea class="form-control"
      id="description"
      name="description"
      rows="4"
      placeholder="Provide detailed information about the issue, including when you noticed it and any safety concerns"
      required><?php echo htmlspecialchars(old('description')); ?></textarea>
    <small class="text-muted">Be as specific as possible to help maintenance team address the issue</small>
  </div>

  <div class="row">
    <!-- Category -->
    <div class="col-md-6 mb-3">
      <label for="category" class="form-label required">Category</label>
      <select class="form-select" id="category" name="category" required>
        <option value="">Select Category</option>
        <option value="Plumbing" <?php echo old('category') == 'Plumbing' ? 'selected' : ''; ?>>
          Plumbing
        </option>
        <option value="Electrical" <?php echo old('category') == 'Electrical' ? 'selected' : ''; ?>>
          Electrical
        </option>
        <option value="Infrastructure" <?php echo old('category') == 'Infrastructure' ? 'selected' : ''; ?>>
          Infrastructure
        </option>
        <option value="HVAC" <?php echo old('category') == 'HVAC' ? 'selected' : ''; ?>>
          HVAC (Heating/Cooling)
        </option>
        <option value="Equipment" <?php echo old('category') == 'Equipment' ? 'selected' : ''; ?>>
          Equipment
        </option>
        <option value="Furniture" <?php echo old('category') == 'Furniture' ? 'selected' : ''; ?>>
          Furniture
        </option>
        <option value="Landscaping" <?php echo old('category') == 'Landscaping' ? 'selected' : ''; ?>>
          Landscaping
        </option>
        <option value="Other" <?php echo old('category') == 'Other' ? 'selected' : ''; ?>>
          Other
        </option>
      </select>
    </div>

    <!-- Location -->
    <div class="col-md-6 mb-3">
      <label for="location" class="form-label required">Location</label>
      <input type="text"
        class="form-control"
        id="location"
        name="location"
        placeholder="e.g., Building A - Room 301"
        value="<?php echo htmlspecialchars(old('location')); ?>"
        required>
      <small class="text-muted">Specify building, floor, and room number</small>
    </div>
  </div>

  <!-- Current Image (Edit Mode Only) -->
  <?php if ($isEdit && !empty($issue['image'])): ?>
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

  <!-- Image Upload -->
  <div class="mb-3">
    <label for="image" class="form-label">
      <?php echo ($isEdit && !empty($issue['image'])) ? 'Upload New Image (Optional)' : 'Upload Image (Optional)'; ?>
    </label>
    <input type="file"
      class="form-control"
      id="image"
      name="image"
      accept="image/jpeg,image/png,image/jpg">
    <small class="form-text text-muted">
      <i class="bi bi-info-circle"></i> Max size: 5MB. Formats: JPG, PNG.
      <?php echo !$isEdit ? 'Images help maintenance team better understand the issue.' : ''; ?>
    </small>
  </div>

  <!-- Image Preview -->
  <div class="mb-3" id="imagePreview" style="display: none;">
    <label class="form-label"><?php echo $isEdit ? 'New Image Preview' : 'Image Preview'; ?></label>
    <div>
      <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 400px;">
      <button type="button" class="btn btn-sm btn-danger mt-2" onclick="clearImage()">
        <i class="bi bi-x"></i> Remove <?php echo $isEdit ? 'New ' : ''; ?>Image
      </button>
    </div>
  </div>

  <?php if (!$isEdit): ?>
    <!-- Info Alert (Create Mode Only) -->
    <div class="alert alert-info">
      <i class="bi bi-info-circle"></i>
      <strong>Note:</strong> All reported issues will be reviewed by the maintenance team.
      You can check the status of your report anytime on the main page.
    </div>
  <?php endif; ?>

  <!-- Form Actions -->
  <div class="d-flex justify-content-between mt-4">
    <a href="<?php echo $isEdit ? 'index.php?action=show&id=' . $issue['id'] : 'index.php'; ?>"
      class="btn btn-secondary">
      <i class="bi bi-arrow-left"></i> <?php echo $isEdit ? 'Cancel' : 'Back to List'; ?>
    </a>
    <button type="submit"
      class="btn <?php echo $isEdit ? 'btn-warning' : 'btn-primary'; ?>"
      id="submitBtn">
      <i class="bi bi-<?php echo $isEdit ? 'save' : 'send'; ?>"></i>
      <?php echo $isEdit ? 'Update Issue' : 'Submit Issue Report'; ?>
    </button>
  </div>
</form>

<style>
  /* Form-specific styles */
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