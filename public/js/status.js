/**
 * status.js
 * Manages updating issue status with confirmation
 * Handles status change interactions and provides user feedback
 */

console.log('Status update script loaded');

// Initialize status update functionality
document.addEventListener('DOMContentLoaded', function () {
  // Handle status form submission with confirmation
  const statusForm = document.getElementById('statusForm');

  if (statusForm) {
    statusForm.addEventListener('submit', function (e) {
      const statusSelect = document.getElementById('statusSelect');

      if (statusSelect) {
        const selectedOption = statusSelect.options[statusSelect.selectedIndex];
        const newStatus = selectedOption.text.trim();

        // Confirm status update with user
        const confirmed = confirm(
          `Are you sure you want to update the status to: ${newStatus}?`
        );

        if (!confirmed) {
          e.preventDefault();
          console.log('Status update cancelled by user');
          return false;
        }

        console.log(`Status updating to: ${newStatus}`);
      }
    });
  }

  // Optional: Add visual feedback when status is being changed
  const statusSelects = document.querySelectorAll('select[name="status"]');
  statusSelects.forEach((select) => {
    select.addEventListener('change', function () {
      console.log(`Status changed to: ${this.value}`);
      // Add visual indicator that status will be updated
      this.style.borderColor = '#ffc107';
      this.style.borderWidth = '2px';
    });
  });
});

/**
 * Future enhancement: AJAX status update without page reload
 * This function can be used to update status via AJAX
 */
function updateStatusAjax(issueId, newStatus) {
  // Placeholder for AJAX implementation
  console.log(`AJAX Update - Issue ${issueId} to ${newStatus}`);

  // Example AJAX call (currently disabled)
  /*
    fetch('index.php?action=updateStatus', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${issueId}&status=${newStatus}`
    })
    .then(response => response.json())
    .then(data => {
        console.log('Status updated successfully');
        // Update UI without page reload
    })
    .catch(error => {
        console.error('Error updating status:', error);
    });
    */
}
