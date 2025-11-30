<?php

/**
 * Issue Controller - PDO Version with DataTables support
 */

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Issue.php';

class IssueController
{
  private $issueModel;
  private $db;

  public function __construct()
  {
    $database = new Database();
    $this->db = $database->getConnection();
    $this->issueModel = new Issue($this->db);
  }

  /**
   * Show dashboard with DataTables
   */
  public function index()
  {
    $pendingCount = $this->issueModel->getCountByStatus('Pending');
    $inProgressCount = $this->issueModel->getCountByStatus('In Progress');
    $completedCount = $this->issueModel->getCountByStatus('Completed');

    require_once __DIR__ . '/../Views/issues/index.php';
  }

  /**
   * JSON endpoint for DataTables AJAX
   * Returns all issues in JSON format
   */
  public function getIssuesJson()
  {
    header('Content-Type: application/json');

    $issues = $this->issueModel->getAll();

    // Format data for DataTables
    $data = array_map(function ($issue) {
      return [
        'id' => $issue['id'],
        'user_id' => htmlspecialchars($issue['user_id']),
        'user_role' => htmlspecialchars($issue['user_role']),
        'title' => htmlspecialchars($issue['title']),
        'category' => htmlspecialchars($issue['category']),
        'location' => htmlspecialchars($issue['location']),
        'status' => $issue['status'],
        'created_date' => $issue['created_date'],
        'created_at' => $issue['created_at'],
        'image' => $issue['image'] ? true : false
      ];
    }, $issues);

    echo json_encode(['data' => $data]);
    exit;
  }

  /**
   * Show create form
   */
  public function create()
  {
    require_once __DIR__ . '/../Views/issues/create.php';
  }

  /**
   * Store new issue
   */
  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('Location: index.php');
      exit;
    }

    $errors = [];

    if (empty($_POST['user_id'])) $errors[] = "User ID is required";
    if (empty($_POST['user_role'])) $errors[] = "User Role is required";
    if (empty($_POST['title'])) $errors[] = "Title is required";
    if (empty($_POST['description'])) $errors[] = "Description is required";
    if (empty($_POST['category'])) $errors[] = "Category is required";
    if (empty($_POST['location'])) $errors[] = "Location is required";

    if (!empty($_POST['user_id']) && !empty($_POST['user_role'])) {
      if (!$this->issueModel->validateUserId($_POST['user_id'], $_POST['user_role'])) {
        $errors[] = "Invalid User ID format";
      }
    }

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      $_SESSION['old_data'] = $_POST;
      header('Location: index.php?action=create');
      exit;
    }

    $imageName = $this->handleImageUpload();

    $data = [
      'user_id' => htmlspecialchars(trim($_POST['user_id'])),
      'user_role' => htmlspecialchars($_POST['user_role']),
      'title' => htmlspecialchars(trim($_POST['title'])),
      'description' => htmlspecialchars(trim($_POST['description'])),
      'category' => htmlspecialchars($_POST['category']),
      'location' => htmlspecialchars(trim($_POST['location'])),
      'image' => $imageName
    ];

    if ($this->issueModel->create($data)) {
      $_SESSION['success'] = "Issue reported successfully!";
      unset($_SESSION['old_data']);
      header('Location: index.php');
    } else {
      $_SESSION['errors'] = ["Failed to create issue"];
      $_SESSION['old_data'] = $_POST;
      header('Location: index.php?action=create');
    }
    exit;
  }

  /**
   * Show single issue
   */
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

  /**
   * Show edit form
   */
  public function edit()
  {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $issue = $this->issueModel->getById($id);

    if (!$issue) {
      $_SESSION['errors'] = ["Issue not found"];
      header('Location: index.php');
      exit;
    }

    require_once __DIR__ . '/../Views/issues/edit.php';
  }

  /**
   * Update issue
   */
  public function update()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('Location: index.php');
      exit;
    }

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $issue = $this->issueModel->getById($id);

    if (!$issue) {
      $_SESSION['errors'] = ["Issue not found"];
      header('Location: index.php');
      exit;
    }

    $errors = [];

    if (empty($_POST['user_id'])) $errors[] = "User ID is required";
    if (empty($_POST['user_role'])) $errors[] = "User Role is required";
    if (empty($_POST['title'])) $errors[] = "Title is required";
    if (empty($_POST['description'])) $errors[] = "Description is required";
    if (empty($_POST['category'])) $errors[] = "Category is required";
    if (empty($_POST['location'])) $errors[] = "Location is required";

    if (!empty($_POST['user_id']) && !empty($_POST['user_role'])) {
      if (!$this->issueModel->validateUserId($_POST['user_id'], $_POST['user_role'])) {
        $errors[] = "Invalid User ID format";
      }
    }

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      header('Location: index.php?action=edit&id=' . $id);
      exit;
    }

    $imageName = $issue['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
      $newImage = $this->handleImageUpload();
      if ($newImage) {
        if ($issue['image']) {
          $oldImagePath = __DIR__ . '/../../public/uploads/' . $issue['image'];
          if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
          }
        }
        $imageName = $newImage;
      }
    }

    $data = [
      'user_id' => htmlspecialchars(trim($_POST['user_id'])),
      'user_role' => htmlspecialchars($_POST['user_role']),
      'title' => htmlspecialchars(trim($_POST['title'])),
      'description' => htmlspecialchars(trim($_POST['description'])),
      'category' => htmlspecialchars($_POST['category']),
      'location' => htmlspecialchars(trim($_POST['location'])),
      'image' => $imageName
    ];

    if ($this->issueModel->update($id, $data)) {
      $_SESSION['success'] = "Issue updated successfully!";
      header('Location: index.php?action=show&id=' . $id);
    } else {
      $_SESSION['errors'] = ["Failed to update issue"];
      header('Location: index.php?action=edit&id=' . $id);
    }
    exit;
  }

  /**
   * Update status only
   */
  public function updateStatus()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('Location: index.php');
      exit;
    }

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    $allowedStatuses = ['Pending', 'In Progress', 'Completed'];
    if (!in_array($status, $allowedStatuses)) {
      $_SESSION['errors'] = ["Invalid status"];
      header('Location: index.php');
      exit;
    }

    if ($this->issueModel->updateStatus($id, $status)) {
      $_SESSION['success'] = "Status updated to " . $status;
    } else {
      $_SESSION['errors'] = ["Failed to update status"];
    }

    $redirect = isset($_POST['redirect']) && $_POST['redirect'] === 'show'
      ? 'index.php?action=show&id=' . $id
      : 'index.php';
    header('Location: ' . $redirect);
    exit;
  }

  /**
   * Delete issue
   */
  public function delete()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('Location: index.php');
      exit;
    }

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($this->issueModel->delete($id)) {
      $_SESSION['success'] = "Issue deleted successfully!";
    } else {
      $_SESSION['errors'] = ["Failed to delete issue"];
    }

    header('Location: index.php');
    exit;
  }

  /**
   * Handle image upload
   * @return string|null Image filename or null
   */
  private function handleImageUpload()
  {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
      return null;
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $maxSize = 5 * 1024 * 1024;

    if (!in_array($_FILES['image']['type'], $allowedTypes) || $_FILES['image']['size'] > $maxSize) {
      return null;
    }

    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = uniqid() . '_' . time() . '.' . $extension;
    $uploadPath = __DIR__ . '/../../public/uploads/' . $imageName;

    if (!is_dir(__DIR__ . '/../../public/uploads/')) {
      mkdir(__DIR__ . '/../../public/uploads/', 0755, true);
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
      return $imageName;
    }

    return null;
  }
}
