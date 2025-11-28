<?php
require_once __DIR__ . '/../Models/Issue.php';

class IssueController
{
  private $issueModel;

  public function __construct()
  {
    $this->issueModel = new Issue();
  }

  // Show all issues with dashboard
  public function index()
  {
    $issues = $this->issueModel->getAll();

    // Get counts for dashboard
    $pendingCount = $this->issueModel->getCountByStatus('Pending');
    $inProgressCount = $this->issueModel->getCountByStatus('In Progress');
    $completedCount = $this->issueModel->getCountByStatus('Completed');

    // Get counts by user role
    $studentCount = $this->issueModel->getCountByUserRole('Student');
    $staffCount = $this->issueModel->getCountByUserRole('Staff');
    $instructorCount = $this->issueModel->getCountByUserRole('Instructor');

    require_once __DIR__ . '/../Views/issues/index.php';
  }

  // Show create form
  public function create()
  {
    require_once __DIR__ . '/../Views/issues/create.php';
  }

  // Store new issue
  public function store()
  {
    $errors = [];

    // Validation
    if (empty($_POST['user_id'])) {
      $errors[] = "User ID is required";
    }
    if (empty($_POST['user_role'])) {
      $errors[] = "User Role is required";
    }
    if (empty($_POST['title'])) {
      $errors[] = "Title is required";
    }
    if (empty($_POST['description'])) {
      $errors[] = "Description is required";
    }
    if (empty($_POST['category'])) {
      $errors[] = "Category is required";
    }
    if (empty($_POST['location'])) {
      $errors[] = "Location is required";
    }

    // Server-side User ID validation
    if (!empty($_POST['user_id']) && !empty($_POST['user_role'])) {
      if (!$this->issueModel->validateUserId($_POST['user_id'], $_POST['user_role'])) {
        $errors[] = "Invalid User ID format for selected role";
      }
    }

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      $_SESSION['old_data'] = $_POST;
      header('Location: index.php?action=create');
      exit;
    }

    // Handle image upload
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
      $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
      $maxSize = 5 * 1024 * 1024; // 5MB

      if (in_array($_FILES['image']['type'], $allowedTypes) && $_FILES['image']['size'] <= $maxSize) {
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '_' . time() . '.' . $extension;
        $uploadPath = __DIR__ . '/../../public/uploads/' . $imageName;

        // Create uploads directory if it doesn't exist
        if (!is_dir(__DIR__ . '/../../public/uploads/')) {
          mkdir(__DIR__ . '/../../public/uploads/', 0755, true);
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
          $imageName = null;
        }
      }
    }

    // Prepare data
    $data = [
      'user_id' => htmlspecialchars(trim($_POST['user_id'])),
      'user_role' => htmlspecialchars($_POST['user_role']),
      'title' => htmlspecialchars(trim($_POST['title'])),
      'description' => htmlspecialchars(trim($_POST['description'])),
      'category' => htmlspecialchars($_POST['category']),
      'location' => htmlspecialchars(trim($_POST['location'])),
      'image' => $imageName
    ];

    // Create issue
    if ($this->issueModel->create($data)) {
      $_SESSION['success'] = "Issue reported successfully! Your report has been submitted.";
      unset($_SESSION['old_data']);
      header('Location: index.php');
    } else {
      $_SESSION['errors'] = ["Failed to create issue. Please check your User ID format."];
      $_SESSION['old_data'] = $_POST;
      header('Location: index.php?action=create');
    }
    exit;
  }

  // Show single issue
  public function show()
  {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $issue = $this->issueModel->getById($id);

    if (!$issue) {
      $_SESSION['errors'] = ["Issue not found"];
      header('Location: index.php');
      exit;
    }

    require_once __DIR__ . '/../Views/issues/show.php';
  }

  // Show edit form
  // Loads existing issue data and displays edit form
  public function edit()
  {
    // Get issue ID from URL parameter
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // Fetch issue data from database
    $issue = $this->issueModel->getById($id);

    // If issue not found, redirect with error
    if (!$issue) {
      $_SESSION['errors'] = ["Issue not found"];
      header('Location: index.php');
      exit;
    }

    // Load edit view and pass $issue data to it
    // The view will automatically display existing values
    require_once __DIR__ . '/../Views/issues/edit.php';
  }

  // Update issue
  public function update()
  {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $issue = $this->issueModel->getById($id);

    if (!$issue) {
      $_SESSION['errors'] = ["Issue not found"];
      header('Location: index.php');
      exit;
    }

    $errors = [];

    // Validation
    if (empty($_POST['user_id'])) {
      $errors[] = "User ID is required";
    }
    if (empty($_POST['user_role'])) {
      $errors[] = "User Role is required";
    }
    if (empty($_POST['title'])) {
      $errors[] = "Title is required";
    }
    if (empty($_POST['description'])) {
      $errors[] = "Description is required";
    }
    if (empty($_POST['category'])) {
      $errors[] = "Category is required";
    }
    if (empty($_POST['location'])) {
      $errors[] = "Location is required";
    }

    // Server-side User ID validation
    if (!empty($_POST['user_id']) && !empty($_POST['user_role'])) {
      if (!$this->issueModel->validateUserId($_POST['user_id'], $_POST['user_role'])) {
        $errors[] = "Invalid User ID format for selected role";
      }
    }

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      header('Location: index.php?action=edit&id=' . $id);
      exit;
    }

    // Handle new image upload
    $imageName = $issue['image']; // Keep old image by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
      $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
      $maxSize = 5 * 1024 * 1024; // 5MB

      if (in_array($_FILES['image']['type'], $allowedTypes) && $_FILES['image']['size'] <= $maxSize) {
        // Delete old image
        if ($issue['image']) {
          $oldImagePath = __DIR__ . '/../../public/uploads/' . $issue['image'];
          if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
          }
        }

        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '_' . time() . '.' . $extension;
        $uploadPath = __DIR__ . '/../../public/uploads/' . $imageName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
          $imageName = $issue['image']; // Revert to old image if upload fails
        }
      }
    }

    // Prepare data
    $data = [
      'user_id' => htmlspecialchars(trim($_POST['user_id'])),
      'user_role' => htmlspecialchars($_POST['user_role']),
      'title' => htmlspecialchars(trim($_POST['title'])),
      'description' => htmlspecialchars(trim($_POST['description'])),
      'category' => htmlspecialchars($_POST['category']),
      'location' => htmlspecialchars(trim($_POST['location'])),
      'image' => $imageName
    ];

    // Update issue
    if ($this->issueModel->update($id, $data)) {
      $_SESSION['success'] = "Issue updated successfully!";
      header('Location: index.php?action=show&id=' . $id);
    } else {
      $_SESSION['errors'] = ["Failed to update issue. Please check your User ID format."];
      header('Location: index.php?action=edit&id=' . $id);
    }
    exit;
  }

  // Update status
  public function updateStatus()
  {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    $allowedStatuses = ['Pending', 'In Progress', 'Completed'];
    if (!in_array($status, $allowedStatuses)) {
      $_SESSION['errors'] = ["Invalid status"];
      header('Location: index.php');
      exit;
    }

    if ($this->issueModel->updateStatus($id, $status)) {
      $_SESSION['success'] = "Status updated successfully to " . $status;
    } else {
      $_SESSION['errors'] = ["Failed to update status"];
    }

    // Redirect back to the issue detail page
    if (isset($_POST['redirect']) && $_POST['redirect'] === 'show') {
      header('Location: index.php?action=show&id=' . $id);
    } else {
      header('Location: index.php');
    }
    exit;
  }

  // Delete issue
  public function delete()
  {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($this->issueModel->delete($id)) {
      $_SESSION['success'] = "Issue deleted successfully!";
    } else {
      $_SESSION['errors'] = ["Failed to delete issue"];
    }

    header('Location: index.php');
    exit;
  }

  // AJAX: Get filtered issues (for search/filter functionality)
  public function filter()
  {
    header('Content-Type: application/json');

    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $userRole = isset($_GET['user_role']) ? $_GET['user_role'] : '';

    $issues = $this->issueModel->searchAndFilter($searchTerm, $status, $category, $userRole);

    echo json_encode($issues);
    exit;
  }
}
