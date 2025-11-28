/**
 * feedbacks.js
 * Controls interactions on the issues listing page
 * Handles table interactions, confirmations, and user feedback
 */

console.log('Issues list script loaded');

// Auto-dismiss alert messages after 5 seconds
function autoDismissAlerts() {
  setTimeout(function () {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach((alert) => {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    });
  }, 5000);
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function () {
  console.log('Issues page initialized');

  // Auto-dismiss alerts
  autoDismissAlerts();

  // Add smooth scroll to table when stat card is clicked
  const statCards = document.querySelectorAll('.stat-card');
  statCards.forEach((card) => {
    card.addEventListener('click', function () {
      const table = document.getElementById('issuesTable');
      if (table) {
        table.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });

  // Enhance delete confirmation with additional info
  const deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
  deleteButtons.forEach((button) => {
    button.addEventListener('click', function () {
      console.log('Delete modal triggered');
    });
  });
});

// Helper function to show toast notifications (optional enhancement)
function showToast(message, type = 'info') {
  // This is a placeholder for future toast notification implementation
  console.log(`Toast [${type}]: ${message}`);
}
