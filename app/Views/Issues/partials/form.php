<?php

/**
 * Form Partial - Reusable Issue Form (Uniform Bootstrap Design)
 * Used by both create.php and edit.php
 */

$isEdit = $isEdit ?? false;
$issue = $issue ?? [];

function old($field, $issueData = [], $default = '')
{
  if (isset($_SESSION['old_data'][$field])) {
    return $_SESSION['old_data'][$field];
  }
  if (isset($issueData[$field])) {
    return $issueData[$field];
  }
  return $default;
}
?>

<form method="<?php echo $method; ?>" action="<?php echo $action; ?>" enctype="multipart/form-data" id="<?php echo $isEdit ? 'editForm' : 'issueForm'; ?>">

  <?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($issue['id']); ?>">
  <?php endif; ?>

  <!-- User Information Section -->
  <h5 class="border-bottom border-2 <?php echo $isEdit ? 'border-warning' : 'border-primary'; ?> border-opacity-25 pb-3 mb-4 text-dark fw-bold">
    <i class="bi bi-person-badge <?php echo $isEdit ? 'text-warning' : 'text-primary'; ?> me-2"></i>Reporter Information
  </h5>

  <div class="row g-3 mb-4">
    <!-- User Role -->
    <div class="col-md-6">
      <label for="user_role" class="form-label fw-semibold">User Role</label>
      <select class="form-select form-select-lg rounded-3 border-2" id="user_role" name="user_role" <?php echo $isEdit ? 'disabled' : ''; ?> <?php echo $isEdit ? '' : 'required'; ?>>
        <option value="">Select Your Role</option>
        <option value="Student" <?php echo old('user_role', $issue) == 'Student' ? 'selected' : ''; ?>>
          👨‍🎓 Student
        </option>
        <option value="Staff" <?php echo old('user_role', $issue) == 'Staff' ? 'selected' : ''; ?>>
          👔 Staff
        </option>
        <option value="Instructor" <?php echo old('user_role', $issue) == 'Instructor' ? 'selected' : ''; ?>>
          👨‍🏫 Instructor
        </option>
      </select>
      <?php if ($isEdit): ?>
        <input type="hidden" name="user_role" value="<?php echo htmlspecialchars(old('user_role', $issue)); ?>">
        <small class="text-muted d-block mt-2">
          <i class="bi bi-lock me-1"></i>Role cannot be changed
        </small>
      <?php endif; ?>
      <div id="userIdError" class="invalid-feedback"></div>
    </div>

    <!-- User ID -->
    <div class="col-md-6">
      <label for="user_id" class="form-label fw-semibold">User ID</label>
      <input type="text"
        class="form-control form-control-lg rounded-3 border-2"
        id="user_id"
        name="user_id"
        placeholder="Enter your ID"
        value="<?php echo htmlspecialchars(old('user_id', $issue)); ?>"
        <?php echo $isEdit ? 'readonly' : ''; ?> <?php echo $isEdit ? '' : 'required'; ?>>
      <?php if ($isEdit): ?>
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars(old('user_id', $issue)); ?>">
        <small class="text-muted d-block mt-2">
          <i class="bi bi-lock me-1"></i>User ID cannot be changed
        </small>
      <?php else: ?>
        <small id="userIdHelp" class="form-text text-muted d-block mt-2">
          <i class="bi bi-info-circle me-1"></i>Please select your role first
        </small>
      <?php endif; ?>
      <div id="userIdError" class="invalid-feedback"></div>
    </div>
  </div>

  <!-- Issue Information Section -->
  <h5 class="border-bottom border-2 <?php echo $isEdit ? 'border-warning' : 'border-primary'; ?> border-opacity-25 pb-3 mb-4 text-dark fw-bold">
    <i class="bi bi-clipboard-data <?php echo $isEdit ? 'text-warning' : 'text-primary'; ?> me-2"></i>Issue Details
  </h5>

  <!-- Issue Title -->
  <div class="mb-4">
    <label for="title" class="form-label fw-semibold">Issue Title</label>
    <input type="text"
      class="form-control form-control-lg rounded-3 border-2"
      id="title"
      name="title"
      placeholder="Brief description (e.g., Broken Window in Classroom)"
      value="<?php echo htmlspecialchars(old('title', $issue)); ?>"
      required>
  </div>

  <!-- Description -->
  <div class="mb-4">
    <label for="description" class="form-label fw-semibold">Detailed Description</label>
    <textarea class="form-control form-control-lg rounded-3 border-2"
      id="description"
      name="description"
      rows="5"
      placeholder="Provide detailed information about the issue, including when you noticed it and any safety concerns"
      required><?php echo htmlspecialchars(old('description', $issue)); ?></textarea>
    <small class="form-text text-muted d-block mt-2">
      Be as specific as possible to help maintenance team address the issue
    </small>
  </div>

  <div class="row g-3 mb-4">
    <!-- Category -->
    <div class="col-md-6">
      <label for="category" class="form-label fw-semibold">Category</label>
      <select class="form-select form-select-lg rounded-3 border-2" id="category" name="category" required>
        <option value="">Select Category</option>
        <option value="Plumbing" <?php echo old('category', $issue) == 'Plumbing' ? 'selected' : ''; ?>>
          🚰 Plumbing
        </option>
        <option value="Electrical" <?php echo old('category', $issue) == 'Electrical' ? 'selected' : ''; ?>>
          ⚡ Electrical
        </option>
        <option value="Infrastructure" <?php echo old('category', $issue) == 'Infrastructure' ? 'selected' : ''; ?>>
          🏗️ Infrastructure
        </option>
        <option value="HVAC" <?php echo old('category', $issue) == 'HVAC' ? 'selected' : ''; ?>>
          ❄️ HVAC
        </option>
        <option value="Equipment" <?php echo old('category', $issue) == 'Equipment' ? 'selected' : ''; ?>>
          🔧 Equipment
        </option>
        <option value="Furniture" <?php echo old('category', $issue) == 'Furniture' ? 'selected' : ''; ?>>
          🪑 Furniture
        </option>
        <option value="Landscaping" <?php echo old('category', $issue) == 'Landscaping' ? 'selected' : ''; ?>>
          🌳 Landscaping
        </option>
        <option value="Other" <?php echo old('category', $issue) == 'Other' ? 'selected' : ''; ?>>
          📦 Other
        </option>
      </select>
    </div>

    <!-- Location -->
    <div class="col-md-6">
      <label for="location" class="form-label fw-semibold">Location</label>
      <input type="text"
        class="form-control form-control-lg rounded-3 border-2"
        id="location"
        name="location"
        placeholder="e.g., Building A - Room 301"
        value="<?php echo htmlspecialchars(old('location', $issue)); ?>"
        required>
      <small class="form-text text-muted d-block mt-2">
        Specify building, floor, and room number
      </small>
    </div>
  </div>

  <!-- Current Image (Edit Mode Only) -->
  <?php if ($isEdit && !empty($issue['image'])): ?>
    <div class="mb-4">
      <label class="form-label fw-semibold">
        <i class="bi bi-image me-2"></i>Current Image
      </label>
      <div class="border border-2 rounded-3 p-3 bg-light">
        <img src="uploads/<?php echo htmlspecialchars($issue['image']); ?>"
          alt="Current Image"
          class="img-fluid rounded-3 shadow-sm"
          style="max-width: 400px;">
      </div>
      <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($issue['image']); ?>">
      <small class="form-text text-muted d-block mt-2">
        <i class="bi bi-info-circle me-1"></i>Upload a new image below to replace this one
      </small>
    </div>
  <?php endif; ?>

  <!-- Image Upload -->
  <div class="mb-4">
    <label for="image" class="form-label fw-semibold">
      <i class="bi bi-cloud-upload me-2"></i><?php echo ($isEdit && !empty($issue['image'])) ? 'Upload New Image (Optional)' : 'Upload Image (Optional)'; ?>
    </label>
    <input type="file"
      class="form-control form-control-lg rounded-3 border-2"
      id="image"
      name="image"
      accept="image/jpeg,image/png,image/jpg">
    <small class="form-text text-muted d-block mt-2">
      <i class="bi bi-info-circle me-1"></i>Max size: 5MB. Formats: JPG, PNG.
      <?php echo !$isEdit ? 'Images help maintenance team better understand the issue.' : ''; ?>
    </small>
  </div>

  <!-- Image Preview -->
  <div class="mb-4 d-none" id="imagePreview">
    <label class="form-label fw-semibold">
      ✨ <?php echo $isEdit ? 'New Image Preview' : 'Image Preview'; ?>
    </label>
    <div class="border border-2 rounded-3 p-3 bg-light">
      <img id="preview" src="" alt="Preview" class="img-fluid rounded-3 shadow-sm" style="max-width: 400px;">
      <button type="button" class="btn <?php echo $isEdit ? 'btn-warning' : 'btn-danger'; ?> btn-sm mt-3 rounded-3" onclick="clearImage()">
        <i class="bi bi-x me-1"></i>Remove <?php echo $isEdit ? 'New ' : ''; ?>Image
      </button>
    </div>
  </div>

  <?php if (!$isEdit): ?>
    <!-- Info Alert (Create Mode Only) -->
    <div class="alert alert-info border-0 border-start border-primary border-4 bg-primary bg-opacity-10 rounded-3">
      <i class="bi bi-info-circle me-2"></i>
      <strong>Note:</strong> All reported issues will be reviewed by the maintenance team.
      You can check the status of your report anytime on the main page.
    </div>
  <?php endif; ?>

  <!-- Form Actions -->
  <div class="d-flex justify-content-between flex-wrap gap-3 mt-4 pt-4 border-top border-2">
    <a href="<?php echo $isEdit ? 'index.php?action=show&id=' . $issue['id'] : 'index.php'; ?>"
      class="btn btn-secondary btn-lg rounded-pill px-4 shadow-sm">
      <i class="bi bi-arrow-left me-2"></i><?php echo $isEdit ? 'Cancel' : 'Back to Dashboard'; ?>
    </a>
    <button type="submit"
      class="btn <?php echo $isEdit ? 'btn-warning' : 'btn-primary'; ?> btn-lg rounded-pill px-4 shadow-sm"
      id="submitBtn">
      <i class="bi bi-<?php echo $isEdit ? 'save' : 'send'; ?> me-2"></i>
      <?php echo $isEdit ? 'Update Issue' : 'Submit Issue Report'; ?>
    </button>
  </div>
</form>

<?php
if (isset($_SESSION['old_data'])) {
  unset($_SESSION['old_data']);
}
?>