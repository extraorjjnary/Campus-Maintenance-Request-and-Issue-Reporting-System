/**
 * dashboard.js
 * Handles DataTables initialization, filtering, and interactions on the issues dashboard
 * Includes stat card clicks, custom search, and delete modal
 */

// Global vars for onclick access
let table;

// Status filter dropdown handler (multi-filter friendly)
$(document).ready(function () {
  // Status dropdown change - no clearing other filters
  $('#statusFilter').on('change', function () {
    const status = this.value;
    $('#statusFilterHidden').val(status);
    if (table) {
      table.draw();
    }
    updateCurrentFilter();
    $('#clearFilters').toggle(
      !!$('#statusFilterHidden').val() ||
        !!$('#categoryFilter').val() ||
        !!$('#roleFilter').val()
    );
  });

  // Category and role also trigger multi-filter
  $('#categoryFilter, #roleFilter').on('change', function () {
    if (table) {
      table.draw();
    }
    updateCurrentFilter();
    $('#clearFilters').toggle(
      !!$('#statusFilterHidden').val() ||
        !!$('#categoryFilter').val() ||
        !!$('#roleFilter').val()
    );
  });

  table = $('#issuesTable').DataTable({
    ajax: {
      url: 'index.php?action=getIssuesJson',
      dataSrc: 'data',
    },
    columns: [
      {
        data: 'id',
        render: (d) => `<strong>#${d}</strong>`,
      },
      {
        data: 'user_id',
        render: (d) => `<code>${d}</code>`,
      },
      {
        data: 'user_role',
        render: (d) => `<span class="badge bg-secondary">${d}</span>`,
      },
      {
        data: 'title',
        render: (d, t, r) => {
          const imageIcon = r.image
            ? '<i class="bi bi-image text-primary"></i> '
            : '';
          return `<strong>${imageIcon}${d}</strong>`;
        },
      },
      {
        data: 'category',
        render: (d) => `<span class="badge bg-secondary">${d}</span>`,
      },
      {
        data: 'location',
      },
      {
        data: 'status',
        render: (d) => {
          const cls = {
            Pending: 'bg-warning text-dark',
            'In Progress': 'bg-info',
            Completed: 'bg-success',
          };
          return `<span class="badge ${
            cls[d] || 'bg-secondary'
          } px-2 py-1 fs-6">${d}</span>`;
        },
      },
      {
        data: 'created_date',
      },
      {
        data: null,
        orderable: false,
        render: (d, t, r) => `
          <div class="btn-group btn-group-sm">
            <a href="index.php?action=show&id=${r.id}" class="btn btn-info"><i class="bi bi-eye"></i></a>
            <a href="index.php?action=edit&id=${r.id}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
            <button class="btn btn-danger delete-btn" data-id="${r.id}" data-title="${r.title}">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        `,
      },
    ],
    order: [[0, 'desc']],
    pageLength: 10,
    drawCallback: function () {
      updateCounts();
    },
  });

  // Hidden status filter
  $('body').append('<input type="hidden" id="statusFilterHidden" value="">');

  // Initial count update after first draw (delayed for AJAX)
  table.on('init.dt', function () {
    setTimeout(updateCounts, 50); // NEW: Short delay to ensure table ready
  });

  // CLEAN HTML BADGE TEXT → raw string
  function extractText(html) {
    return $('<div>').html(html).text().trim();
  }

  // Update counts based on filtered data
  function updateCounts() {
    try {
      if (!table || !table.rows) return; // NEW: Strong null check
      const filteredData = table.rows({ filter: 'applied' }).data().toArray();
      const counts = { Pending: 0, 'In Progress': 0, Completed: 0 };
      filteredData.forEach((row) => {
        const status = row.status;
        if (counts[status] !== undefined) {
          counts[status]++;
        }
      });
      $('#pendingCount').text(counts['Pending'] || 0);
      $('#inProgressCount').text(counts['In Progress'] || 0);
      $('#completedCount').text(counts['Completed'] || 0);
      const info = table.page.info();
      $('#totalCount').text(info.recordsDisplay);
    } catch (e) {
      // Silent fail—don't log every time
    }
  }

  // Update current filter display
  function updateCurrentFilter() {
    try {
      const status = $('#statusFilterHidden').val();
      const cat = $('#categoryFilter').val();
      const role = $('#roleFilter').val();
      const filters = [];
      if (status) filters.push(status);
      if (cat) filters.push(cat);
      if (role) filters.push(role);
      let text;
      if (filters.length === 0) {
        text = 'All Issues';
      } else if (filters.length === 1) {
        const f = filters[0];
        if (f === status) {
          text = f;
        } else if (f === cat) {
          text = `Category: ${f}`;
        } else {
          text = `Role: ${f}`;
        }
      } else {
        text = 'Multiple Filters';
      }
      $('#currentFilter').text(text);
    } catch (e) {
      console.error('Error updating filter display:', e);
    }
  }

  // FIXED FILTER LOGIC
  $.fn.dataTable.ext.search.push(function (settings, data) {
    try {
      const statusFilter = $('#statusFilterHidden').val();
      const categoryFilter = $('#categoryFilter').val();
      const roleFilter = $('#roleFilter').val();

      const rowRole = extractText(data[2]);
      const rowCategory = extractText(data[4]);
      const rowStatus = extractText(data[6]);

      if (statusFilter && rowStatus !== statusFilter) return false;
      if (categoryFilter && rowCategory !== categoryFilter) return false;
      if (roleFilter && rowRole !== roleFilter) return false;

      return true;
    } catch (e) {
      console.error('Error in filter logic:', e);
      return true; // Fallback to show row
    }
  });

  // Clear filters
  $('#clearFilters').on('click', function () {
    $('#statusFilterHidden').val('');
    $('#statusFilter').val(''); // NEW: Clear the dropdown too
    $('#categoryFilter').val('');
    $('#roleFilter').val('');
    updateCurrentFilter();
    if (table) {
      table.draw();
    }
    $(this).hide();
  });

  // Delete modal
  $(document).on('click', '.delete-btn', function () {
    try {
      $('#deleteIssueId').val($(this).data('id'));
      $('#deleteIssueName').text($(this).data('title'));
      new bootstrap.Modal(document.getElementById('deleteModal')).show();
    } catch (e) {
      console.error('Error opening delete modal:', e);
    }
  });

  // Initial update
  updateCurrentFilter();
});
