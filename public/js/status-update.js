/**
 * status-update.js
 * Enhanced status update with confirmation modal
 * Shows current vs new status before updating
 */

document.addEventListener('DOMContentLoaded', function () {
  const statusForm = document.getElementById('statusForm');
  const statusSelect = document.getElementById('statusSelect');
  const confirmBtn = document.getElementById('confirmStatusUpdate');

  // Exit if elements don't exist (not on show page)
  if (!statusForm || !statusSelect || !confirmBtn) {
    return;
  }

  const confirmModal = new bootstrap.Modal(
    document.getElementById('statusConfirmModal')
  );

  // Status configuration with icons and colors
  const statusConfig = {
    Pending: { icon: '⏳', class: 'bg-warning text-dark' },
    'In Progress': { icon: '⚙️', class: 'bg-info text-white' },
    Completed: { icon: '✅', class: 'bg-success text-white' },
  };

  /**
   * Intercept form submission to show confirmation modal
   */
  statusForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const currentStatus = statusSelect.dataset.current;
    const newStatus = statusSelect.value;

    // Validation: Skip if no change
    if (currentStatus === newStatus) {
      alert('No changes detected. Please select a different status.');
      return;
    }

    // Update modal badges with current and new status
    updateModalBadges(currentStatus, newStatus);

    // Show confirmation modal
    confirmModal.show();
  });

  /**
   * Handle confirm button click
   */
  confirmBtn.addEventListener('click', function () {
    const submitBtn = statusForm.querySelector('button[type="submit"]');

    // Disable button and show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML =
      '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';

    // Hide modal and submit form
    confirmModal.hide();
    statusForm.submit();
  });

  /**
   * Visual feedback when status changes in dropdown
   */
  statusSelect.addEventListener('change', function () {
    const currentStatus = this.dataset.current;

    // Remove previous styling
    this.classList.remove('border-warning', 'border-3');

    // Add yellow border if changed
    if (this.value !== currentStatus) {
      this.classList.add('border-warning', 'border-3');
    }
  });

  /**
   * Update confirmation modal badges
   * @param {string} currentStatus - Current status value
   * @param {string} newStatus - New status value
   */
  function updateModalBadges(currentStatus, newStatus) {
    const currentConfig = statusConfig[currentStatus];
    const newConfig = statusConfig[newStatus];

    const currentBadge = document.getElementById('currentStatusBadge');
    const newBadge = document.getElementById('newStatusBadge');

    // Update current status badge
    if (currentBadge && currentConfig) {
      currentBadge.innerHTML = `${currentConfig.icon} ${currentStatus}`;
      currentBadge.className = `badge ${currentConfig.class} px-3 py-2`;
    }

    // Update new status badge
    if (newBadge && newConfig) {
      newBadge.innerHTML = `${newConfig.icon} ${newStatus}`;
      newBadge.className = `badge ${newConfig.class} px-3 py-2`;
    }
  }
});
