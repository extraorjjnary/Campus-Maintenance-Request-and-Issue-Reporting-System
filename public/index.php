<?php
// Start session
session_start();

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include controller
require_once __DIR__ . '/../app/Controllers/IssueController.php';

// Create controller instance
$controller = new IssueController();

// Get action from URL parameter
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Route to appropriate method
switch ($action) {
  case 'index':
    // Display all issues (main dashboard)
    $controller->index();
    break;

  case 'create':
    // Show create form
    $controller->create();
    break;

  case 'store':
    // Store new issue (POST only)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $controller->store();
    } else {
      header('Location: index.php');
      exit;
    }
    break;

  case 'show':
    // Show single issue detail
    $controller->show();
    break;

  case 'edit':
    // Show edit form
    $controller->edit();
    break;

  case 'update':
    // Update issue (POST only)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $controller->update();
    } else {
      header('Location: index.php');
      exit;
    }
    break;

  case 'updateStatus':
    // Update issue status (POST only)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $controller->updateStatus();
    } else {
      header('Location: index.php');
      exit;
    }
    break;

  case 'delete':
    // Delete issue (POST only)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $controller->delete();
    } else {
      header('Location: index.php');
      exit;
    }
    break;

  case 'filter':
    // AJAX filter endpoint (for future enhancements)
    $controller->filter();
    break;

  default:
    // Default to index
    $controller->index();
    break;
}
