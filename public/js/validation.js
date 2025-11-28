/**
 * validation.js
 * Handles User ID validation for create and edit forms
 * Provides real-time validation feedback to users
 */

console.log('Validation script loaded');

// Initialize validation when page loads
document.addEventListener('DOMContentLoaded', function () {
  // Get form elements
  const userRoleSelect = document.getElementById('user_role');
  const userIdInput = document.getElementById('user_id');
  const userIdHelp = document.getElementById('userIdHelp');
  const userIdError = document.getElementById('userIdError');
  const issueForm =
    document.getElementById('issueForm') || document.getElementById('editForm');
  const submitBtn = document.getElementById('submitBtn');

  // Check if we're on a form page
  if (!userRoleSelect || !userIdInput) {
    console.log('Not on form page, validation not initialized');
    return;
  }

  console.log('Validation initialized successfully');

  /**
   * ID Format patterns for different user roles
   * Student: YY-XXXX (e.g., 23-4302)
   * Staff/Instructor: EMP-XXXX (e.g., EMP-2043)
   */
  const patterns = {
    Student: /^[0-9]{2}-[0-9]{4}$/,
    Staff: /^EMP-[0-9]{4}$/,
    Instructor: /^EMP-[0-9]{4}$/,
  };

  /**
   * Update help text based on selected role
   */
  function updateHelpText() {
    const role = userRoleSelect.value;

    if (role === 'Student') {
      userIdHelp.innerHTML =
        '<i class="bi bi-info-circle"></i> Format: <strong>YY-XXXX</strong> (e.g., 23-4302)';
      userIdInput.placeholder = 'e.g., 23-4302';
    } else if (role === 'Staff' || role === 'Instructor') {
      userIdHelp.innerHTML =
        '<i class="bi bi-info-circle"></i> Format: <strong>EMP-XXXX</strong> (e.g., EMP-2043)';
      userIdInput.placeholder = 'e.g., EMP-2043';
    } else {
      userIdHelp.innerHTML =
        '<i class="bi bi-info-circle"></i> Please select your role first';
      userIdInput.placeholder = 'Enter your ID';
    }

    console.log(`Help text updated for role: ${role}`);
  }

  /**
   * Validate User ID against the pattern for selected role
   * Returns true if valid, false otherwise
   */
  function validateUserId() {
    const role = userRoleSelect.value;
    const userId = userIdInput.value.trim();

    // Check if role is selected
    if (!role) {
      userIdError.textContent = 'Please select your role first';
      userIdError.style.display = 'block';
      userIdInput.classList.add('is-invalid');
      userIdInput.classList.remove('is-valid');
      return false;
    }

    // If input is empty, just remove validation classes
    if (!userId) {
      userIdError.style.display = 'none';
      userIdInput.classList.remove('is-invalid', 'is-valid');
      return false;
    }

    // Check if ID matches the pattern for selected role
    const pattern = patterns[role];
    if (!pattern.test(userId)) {
      let formatMessage = '';
      if (role === 'Student') {
        formatMessage = 'Student ID must be in format: YY-XXXX (e.g., 23-4302)';
      } else {
        formatMessage =
          'Staff/Instructor ID must be in format: EMP-XXXX (e.g., EMP-2043)';
      }

      userIdError.textContent = formatMessage;
      userIdError.style.display = 'block';
      userIdInput.classList.add('is-invalid');
      userIdInput.classList.remove('is-valid');

      console.warn(`Invalid User ID: ${userId} for role: ${role}`);
      return false;
    } else {
      // Valid ID
      userIdError.style.display = 'none';
      userIdInput.classList.remove('is-invalid');
      userIdInput.classList.add('is-valid');

      console.log(`Valid User ID: ${userId} for role: ${role}`);
      return true;
    }
  }

  /**
   * Validate all required fields before form submission
   */
  function validateForm() {
    const title = document.getElementById('title')?.value.trim();
    const description = document.getElementById('description')?.value.trim();
    const category = document.getElementById('category')?.value;
    const location = document.getElementById('location')?.value.trim();
    const role = userRoleSelect.value;

    // Check User ID first
    if (!validateUserId()) {
      alert('Please enter a valid User ID for your selected role');
      userIdInput.focus();
      return false;
    }

    // Check other required fields
    if (!title || !description || !category || !location || !role) {
      alert('Please fill in all required fields');
      return false;
    }

    return true;
  }

  // Event listener: Update help text when role changes
  userRoleSelect.addEventListener('change', function () {
    updateHelpText();
    userIdInput.value = ''; // Clear previous input
    userIdError.style.display = 'none';
    userIdInput.classList.remove('is-invalid', 'is-valid');

    console.log(`User role changed to: ${this.value}`);
  });

  // Event listener: Real-time validation on input
  userIdInput.addEventListener('input', function () {
    validateUserId();
  });

  // Event listener: Form submission validation
  if (issueForm) {
    issueForm.addEventListener('submit', function (e) {
      console.log('Form submission attempted');

      if (!validateForm()) {
        e.preventDefault();
        console.warn('Form validation failed, submission prevented');
        return false;
      }

      // Show loading state on submit button
      if (submitBtn) {
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML =
          '<span class="spinner-border spinner-border-sm"></span> Submitting...';

        console.log('Form validated successfully, submitting...');
      }
    });
  }

  // Initialize help text on page load (for edit form)
  updateHelpText();

  // If editing, validate existing User ID on page load
  if (userIdInput.value) {
    validateUserId();
  }

  console.log('Validation event listeners attached');
});
