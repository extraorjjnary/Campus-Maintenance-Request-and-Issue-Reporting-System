/**
 * alerts.js
 * Auto-dismisses Bootstrap alerts (success/error) after 3 seconds
 * Used across all views with session-based messages
 */

document.addEventListener('DOMContentLoaded', function () {
  const alerts = document.querySelectorAll('.alert-success, .alert-danger');
  alerts.forEach(function (alert) {
    setTimeout(function () {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }, 3000); // 3 seconds delay
  });
});
