/**
 * status.js
 * Manages updating issue status with confirmation
 * Handles status change interactions and provides user feedback
 */

// Initialize status update functionality
document.addEventListener('DOMContentLoaded', function () {
  // Handle status form submission with confirmation
  const statusForm = document.getElementById('statusForm');

  if (statusForm) {
    statusForm.addEventListener('submit', function (e) {
      const statusSelect = document.getElementById('statusSelect');
      const submitBtn = statusForm.querySelector('button[type="submit"]');

      if (statusSelect) {
        const newStatus = statusSelect.value;
        const currentStatus = statusSelect.dataset.current || ''; // Assume data-current on select for current value

        // Skip confirm if no change
        if (newStatus === currentStatus) {
          return;
        }

        // Confirm status update with user
        const confirmed = confirm(
          `Are you sure you want to update the status to: ${newStatus}?`
        );

        if (!confirmed) {
          e.preventDefault();
          return false;
        }

        // Add loading spinner
        if (submitBtn) {
          submitBtn.disabled = true;
          const originalText = submitBtn.innerHTML;
          submitBtn.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2"></span> Updating...';
        }
      }
    });
  }

  // Visual feedback when status is changed
  const statusSelects = document.querySelectorAll('select[name="status"]');
  statusSelects.forEach((select) => {
    select.addEventListener('change', function () {
      // Reset previous
      this.classList.remove('border-warning', 'border-2');

      // Add yellow border if changed
      if (this.value !== this.dataset.current) {
        this.classList.add('border-warning', 'border-2');
      }
    });
  });
});
