/**
 * dashboard.js
 * Handles DataTables initialization, filtering, customize search. and interactions on the issues dashboard
 * Includes stat card updated whenever filtered data, custom search, and delete modal
 */

// Global vars for onclick access
let table;

$(document).ready(function () {
  // Initialize DataTable
  table = $('#issuesTable').DataTable({
    ajax: {
      url: 'index.php?action=getIssuesJson',
      dataSrc: 'data',
    },
    columns: [
      // Keep Database ID (Recommended - Permanent Reference)
      {
        data: 'id',
        render: (d) => `<strong class="text-primary">#${d}</strong>`,
        width: '80px',
      },
      {
        data: 'user_id',
        render: (d) => `<code class="bg-light px-2 py-1 rounded">${d}</code>`,
      },
      {
        data: 'user_role',
        render: (d) => {
          const icons = {
            Student: '👨‍🎓',
            Staff: '👔',
            Instructor: '👨‍🏫',
          };
          return `<span class="badge bg-secondary">${
            icons[d] || ''
          } ${d}</span>`;
        },
      },
      {
        data: 'title',
        render: (d, t, r) => {
          const imageIcon = r.image
            ? '<i class="bi bi-image text-primary me-1"></i>'
            : '';
          return `${imageIcon}<strong>${d}</strong>`;
        },
      },
      {
        data: 'category',
        render: (d) => {
          const icons = {
            Plumbing: '🚰',
            Electrical: '⚡',
            Infrastructure: '🏗️',
            HVAC: '❄️',
            Equipment: '🔧',
            Furniture: '🪑',
            Landscaping: '🌳',
            Other: '📦',
          };
          return `<span class="badge bg-secondary">${
            icons[d] || ''
          } ${d}</span>`;
        },
      },
      {
        data: 'location',
        render: (d) => `<i class="bi bi-geo-alt text-muted me-1"></i>${d}`,
      },
      {
        data: 'status',
        render: (d) => {
          const statusConfig = {
            Pending: { class: 'bg-warning text-dark', icon: '⏳' },
            'In Progress': { class: 'bg-info text-white', icon: '⚙️' },
            Completed: { class: 'bg-success text-white', icon: '✅' },
          };
          const config = statusConfig[d] || { class: 'bg-secondary', icon: '' };
          return `<span class="badge ${config.class} px-3 py-2 rounded-pill">${config.icon} ${d}</span>`;
        },
      },
      {
        data: 'created_date',
        render: (d) =>
          `<small class="text-muted"><i class="bi bi-calendar3 me-1"></i>${d}</small>`,
      },
      {
        data: null,
        orderable: false,
        searchable: false,
        render: (d, t, r) => `
          <div class="btn-group btn-group-sm" role="group">
            <a href="index.php?action=show&id=${r.id}" 
               class="btn btn-info rounded-start" 
               title="View Details">
              <i class="bi bi-eye"></i>
            </a>
            <a href="index.php?action=edit&id=${r.id}" 
               class="btn btn-warning" 
               title="Edit Issue">
              <i class="bi bi-pencil"></i>
            </a>
            <button class="btn btn-danger delete-btn rounded-end" 
                    data-id="${r.id}" 
                    data-title="${r.title}"
                    title="Delete Issue">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        `,
        width: '140px',
      },
    ],
    order: [[0, 'desc']], // Sort by ID descending (newest first)
    pageLength: 10,
    lengthMenu: [
      [10, 25, 50, 100],
      [10, 25, 50, 100],
    ],
    language: {
      search: 'Search issues:',
      lengthMenu: 'Show _MENU_ issues per page',
      info: 'Showing _START_ to _END_ of _TOTAL_ issues',
      infoEmpty: 'No issues found',
      infoFiltered: '(filtered from _MAX_ total issues)',
      emptyTable: 'No maintenance issues reported yet',
      zeroRecords: 'No matching issues found',
    },
    drawCallback: function () {
      updateCounts();
    },
    initComplete: function () {
      updateCounts();
    },
  });

  // Hidden status filter input
  if ($('#statusFilterHidden').length === 0) {
    $('body').append('<input type="hidden" id="statusFilterHidden" value="">');
  }

  // Status filter dropdown handler
  $('#statusFilter').on('change', function () {
    const status = this.value;
    $('#statusFilterHidden').val(status);
    if (table) {
      table.draw();
    }
    updateCurrentFilter();
    toggleClearButton();
  });

  // Category and role filters
  $('#categoryFilter, #roleFilter').on('change', function () {
    if (table) {
      table.draw();
    }
    updateCurrentFilter();
    toggleClearButton();
  });

  // Helper: Clean HTML to extract plain text (improved to handle emojis)
  function extractText(html) {
    if (!html) return '';
    // Remove HTML tags and trim, keeping emojis and text
    const text = $('<div>').html(html).text().trim();
    // Remove emojis and extra spaces, keep only the actual text
    return text.replace(/[\u{1F300}-\u{1F9FF}]/gu, '').trim();
  }

  // Update stat card counts based on filtered data
  function updateCounts() {
    try {
      if (!table || !table.rows) return;

      const filteredData = table.rows({ filter: 'applied' }).data().toArray();
      const counts = {
        Pending: 0,
        'In Progress': 0,
        Completed: 0,
      };

      filteredData.forEach((row) => {
        const status = row.status;
        if (counts[status] !== undefined) {
          counts[status]++;
        }
      });

      // Update stat cards with animation
      $('#pendingCount').text(counts['Pending'] || 0);
      $('#inProgressCount').text(counts['In Progress'] || 0);
      $('#completedCount').text(counts['Completed'] || 0);

      const info = table.page.info();
      $('#totalCount').text(info.recordsDisplay || 0);
    } catch (e) {
      console.error('Error updating counts:', e);
    }
  }

  // Update current filter badge display
  function updateCurrentFilter() {
    try {
      const status = $('#statusFilterHidden').val();
      const cat = $('#categoryFilter').val();
      const role = $('#roleFilter').val();
      const filters = [];

      if (status) filters.push(status);
      if (cat) filters.push(cat);
      if (role) filters.push(role);

      let text = 'All Issues';

      if (filters.length === 1) {
        const f = filters[0];
        text = f; // Just show the filter value
      } else if (filters.length > 1) {
        text = `${filters.length} Filters Active`;
      }

      $('#currentFilter').text(text);
    } catch (e) {
      console.error('Error updating filter display:', e);
    }
  }

  // Toggle clear filters button visibility
  function toggleClearButton() {
    const hasFilters =
      !!$('#statusFilterHidden').val() ||
      !!$('#categoryFilter').val() ||
      !!$('#roleFilter').val();

    $('#clearFilters').toggle(hasFilters);
  }

  // Custom DataTables search filter - FIXED TO USE RAW DATA
  $.fn.dataTable.ext.search.push(function (settings, data, dataIndex, rowData) {
    try {
      const statusFilter = $('#statusFilterHidden').val();
      const categoryFilter = $('#categoryFilter').val();
      const roleFilter = $('#roleFilter').val();

      // Use raw data from the row object instead of rendered HTML
      if (!rowData) return true;

      const rowRole = rowData.user_role || '';
      const rowCategory = rowData.category || '';
      const rowStatus = rowData.status || '';

      // Apply filters - exact match
      if (statusFilter && rowStatus !== statusFilter) return false;
      if (categoryFilter && rowCategory !== categoryFilter) return false;
      if (roleFilter && rowRole !== roleFilter) return false;

      return true;
    } catch (e) {
      console.error('Error in filter logic:', e);
      return true; // Show row on error (fail-safe)
    }
  });

  // Clear all filters
  $('#clearFilters').on('click', function () {
    $('#statusFilterHidden').val('');
    $('#statusFilter').val('');
    $('#categoryFilter').val('');
    $('#roleFilter').val('');

    updateCurrentFilter();

    if (table) {
      table.draw();
    }

    $(this).hide();
  });

  // Delete modal handler
  $(document).on('click', '.delete-btn', function () {
    try {
      const issueId = $(this).data('id');
      const issueTitle = $(this).data('title');

      $('#deleteIssueId').val(issueId);
      $('#deleteIssueName').text(issueTitle);

      const deleteModal = new bootstrap.Modal(
        document.getElementById('deleteModal')
      );
      deleteModal.show();
    } catch (e) {
      console.error('Error opening delete modal:', e);
      alert('Error opening delete confirmation. Please try again.');
    }
  });

  // Initial setup
  updateCurrentFilter();
  toggleClearButton();

  // Optional: Add keyboard shortcut for search
  $(document).on('keypress', function (e) {
    // Press '/' to focus search
    if (e.key === '/' && !$(e.target).is('input, textarea')) {
      e.preventDefault();
      $('.dataTables_filter input').focus();
    }
  });
});
