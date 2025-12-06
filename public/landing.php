<?php

/**
 * Landing Page Router - Public Access
 * Handles public issue reporting without authentication
 */


$action = isset($_GET['action']) ? $_GET['action'] : 'landing';

if ($action === 'publicCreate') {
  // Show public create form
  require_once __DIR__ . '/../app/Views/public/create_public.php';
  exit;
}

if ($action === 'publicStore') {
  // Handle public issue submission
  require_once __DIR__ . '/../config/database.php';
  require_once __DIR__ . '/../app/Models/Issue.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: landing.php');
    exit;
  }

  $database = new Database();
  $db = $database->getConnection();
  $issueModel = new Issue($db);

  $errors = [];

  if (empty($_POST['user_id'])) $errors[] = "User ID is required";
  if (empty($_POST['user_role'])) $errors[] = "User Role is required";
  if (empty($_POST['title'])) $errors[] = "Title is required";
  if (empty($_POST['description'])) $errors[] = "Description is required";
  if (empty($_POST['category'])) $errors[] = "Category is required";
  if (empty($_POST['location'])) $errors[] = "Location is required";

  if (!empty($_POST['user_id']) && !empty($_POST['user_role'])) {
    if (!$issueModel->validateUserId($_POST['user_id'], $_POST['user_role'])) {
      $errors[] = "Invalid User ID format";
    }
  }

  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old_data'] = $_POST;
    header('Location: landing.php?action=publicCreate');
    exit;
  }

  // Handle image upload
  $imageName = null;
  if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $maxSize = 5 * 1024 * 1024;

    if (in_array($_FILES['image']['type'], $allowedTypes) && $_FILES['image']['size'] <= $maxSize) {
      $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
      $imageName = uniqid() . '_' . time() . '.' . $extension;
      $uploadPath = __DIR__ . '/uploads/' . $imageName;

      if (!is_dir(__DIR__ . '/uploads/')) {
        mkdir(__DIR__ . '/uploads/', 0755, true);
      }

      move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath);
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

  if ($issueModel->create($data)) {
    $_SESSION['success'] = "Issue reported successfully! Our maintenance team will review it shortly.";
    unset($_SESSION['old_data']);
    header('Location: landing.php');
  } else {
    $_SESSION['errors'] = ["Failed to create issue"];
    $_SESSION['old_data'] = $_POST;
    header('Location: landing.php?action=publicCreate');
  }
  exit;
}

// Default: Show landing page
require_once __DIR__ . '/../app/Views/public/landing.php';
