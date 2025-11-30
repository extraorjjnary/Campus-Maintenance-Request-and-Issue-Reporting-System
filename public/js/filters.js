/**
 * filters.js
 * Handles search and filter inputs to narrow the issue list
 * Provides real-time filtering without page reload
 */

console.log('Filters script loaded');

// Initialize filter functionality when page loads
document.addEventListener('DOMContentLoaded', function () {
  // Get all filter elements
  const searchInput = document.getElementById('searchInput');
  const statusFilter = document.getElementById('statusFilter');
  const categoryFilter = document.getElementById('categoryFilter');
  const userRoleFilter = document.getElementById('userRoleFilter');
  const tableBody = document.getElementById('issuesTableBody');
  const noResultsMessage = document.getElementById('noResultsMessage');

  // Check if we're on the issues list page
  if (!searchInput || !tableBody) {
    console.log('Not on issues list page, filters not initialized');
    return;
  }

  console.log('Filters initialized successfully');

  /**
   * Main filter function - applies all active filters
   * Runs every time user types or changes a filter
   */
  function applyFilters() {
    // Get current filter values
    const searchTerm = searchInput.value.toLowerCase();
    const statusValue = statusFilter.value;
    const categoryValue = categoryFilter.value;
    const userRoleValue = userRoleFilter.value;

    // Get all table rows (excluding the "no data" row)
    const rows = tableBody.querySelectorAll('tr:not(#noDataRow)');
    let visibleCount = 0;

    // Loop through each row and check if it matches filters
    rows.forEach((row) => {
      // Get data attributes from row
      const searchText = row.getAttribute('data-search-text') || '';
      const status = row.getAttribute('data-status') || '';
      const category = row.getAttribute('data-category') || '';
      const userRole = row.getAttribute('data-user-role') || '';

      let showRow = true; // Assume row should be shown

      // Check search filter
      if (searchTerm && !searchText.includes(searchTerm)) {
        showRow = false;
      }

      // Check status filter (skip if empty, means show all)
      if (statusValue && statusValue !== '' && status !== statusValue) {
        showRow = false;
      }

      // Check category filter
      if (categoryValue && category !== categoryValue) {
        showRow = false;
      }

      // Check user role filter
      if (userRoleValue && userRole !== userRoleValue) {
        showRow = false;
      }

      // Show or hide the row
      if (showRow) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    // Show "no results" message if no rows are visible
    if (visibleCount === 0 && rows.length > 0) {
      noResultsMessage.style.display = 'block';
    } else {
      noResultsMessage.style.display = 'none';
    }

    console.log(
      `Filters applied: ${visibleCount} of ${rows.length} issues visible`
    );
  }

  /**
   * Clear all filters and show all rows
   */
  window.clearFilters = function () {
    searchInput.value = '';
    statusFilter.value = '';
    categoryFilter.value = '';
    userRoleFilter.value = '';
    applyFilters();
    console.log('All filters cleared');
  };

  /**
   * Filter by status - called when stat cards are clicked
   */
  window.filterByStatus = function (status) {
    // Accept empty string '' to clear the status filter
    if (status === '') {
      statusFilter.value = '';
    } else {
      statusFilter.value = status;
    }
    applyFilters();
    console.log(`Filtered by status: ${status}`);

    // Scroll to table smoothly
    const table = document.getElementById('issuesTable');
    if (table) {
      table.scrollIntoView({ behavior: 'smooth' });
    }
  };

  // Add event listeners for real-time filtering
  searchInput.addEventListener('input', function () {
    console.log(`Searching for: ${this.value}`);
    applyFilters();
  });

  statusFilter.addEventListener('change', function () {
    console.log(`Status filter changed to: ${this.value}`);
    applyFilters();
  });

  categoryFilter.addEventListener('change', function () {
    console.log(`Category filter changed to: ${this.value}`);
    applyFilters();
  });

  userRoleFilter.addEventListener('change', function () {
    console.log(`User role filter changed to: ${this.value}`);
    applyFilters();
  });

  console.log('Filter event listeners attached');
});
