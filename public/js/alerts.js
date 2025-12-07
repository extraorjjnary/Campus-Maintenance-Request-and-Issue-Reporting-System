/**
 * alerts.js
 * Auto-dismisses Bootstrap alerts (success/error) after 3 seconds
 * Also initializes and auto-shows any Toasts (for consistency)
 * Used across all views with session-based messages
 */

document.addEventListener('DOMContentLoaded', function () {
  // Auto-dismiss alerts (3s for quick feedback)
  const alerts = document.querySelectorAll('.alert-success, .alert-danger');
  alerts.forEach(function (alert) {
    setTimeout(function () {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }, 3000); // 3 seconds delay
  });

  // Auto-show Toasts (e.g., success banners) - 5s delay via data-bs-delay
  const toastElList = [].slice.call(document.querySelectorAll('.toast'));
  const toastList = toastElList.map(function (toastEl) {
    return new bootstrap.Toast(toastEl);
  });
  toastList.forEach((toast) => toast.show());
});
