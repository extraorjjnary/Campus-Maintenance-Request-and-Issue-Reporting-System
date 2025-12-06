<?php

/**
 * Auth Controller - Simple Authentication
 * Handles login, logout, and session management
 */

class AuthController
{
  private $adminUsername = 'admin';
  private $adminPassword = 'adminpassword';

  /**
   * Show login page
   */
  public function showLogin()
  {
    // If already logged in, redirect to dashboard
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
      header('Location: index.php');
      exit;
    }

    require_once __DIR__ . '/../../app/Views/auth/login.php';
  }

  /**
   * Process login
   */
  public function login()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      header('Location: index.php?action=showLogin');
      exit;
    }

    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validate credentials
    if ($username === $this->adminUsername && $password === $this->adminPassword) {
      $_SESSION['admin_logged_in'] = true;
      $_SESSION['admin_username'] = $username;
      $_SESSION['success'] = "Welcome back, Admin!";
      header('Location: index.php');
      exit;
    } else {
      $_SESSION['errors'] = ["Invalid username or password"];
      header('Location: index.php?action=showLogin');
      exit;
    }
  }

  /**
   * Logout
   */
  public function logout()
  {
    // Clear session
    unset($_SESSION['admin_logged_in']);
    unset($_SESSION['admin_username']);
    $_SESSION['success'] = "You have been logged out successfully";
    header('Location: landing.php');
    exit;
  }

  /**
   * Check if user is admin (middleware function)
   */
  public static function requireAdmin()
  {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
      $_SESSION['errors'] = ["You must be logged in as admin to access this page"];
      header('Location: index.php?action=showLogin');
      exit;
    }
  }
}
