<?php

/**
 * Main Router - Entry Point
 * Handles all requests and routes to appropriate controller methods
 */

session_start();

require_once __DIR__ . '/../app/Controllers/IssueController.php';

$controller = new IssueController();
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

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
