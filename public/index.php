<?php

/**
 * Main Router - Entry Point with Authentication
 * Handles all requests and routes to appropriate controller methods
 */

session_start();

require_once __DIR__ . '/../app/Controllers/IssueController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Auth actions (no login required)
if ($action === 'showLogin') {
  $authController = new AuthController();
  $authController->showLogin();
  exit;
}

if ($action === 'login') {
  $authController = new AuthController();
  $authController->login();
  exit;
}

if ($action === 'logout') {
  $authController = new AuthController();
  $authController->logout();
  exit;
}

// All other actions require admin authentication
AuthController::requireAdmin();

$controller = new IssueController();

switch ($action) {
  case 'index':
    $controller->index();
    break;

  case 'getIssuesJson':
    $controller->getIssuesJson();
    break;

  case 'create':
    $controller->create();
    break;

  case 'store':
    $controller->store();
    break;

  case 'show':
    $controller->show();
    break;

  case 'edit':
    $controller->edit();
    break;

  case 'update':
    $controller->update();
    break;

  case 'updateStatus':
    $controller->updateStatus();
    break;

  case 'delete':
    $controller->delete();
    break;

  default:
    $controller->index();
    break;
}
