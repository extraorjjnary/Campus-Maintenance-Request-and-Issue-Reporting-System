<?php
require_once __DIR__ . '/../../config/database.php';

class Issue
{
  private $conn;
  private $table = 'issues';

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->connect();
  }

  // Validate User ID format
  public function validateUserId($userId, $userRole)
  {
    // Student ID format: YY-XXXX (e.g., 23-4302)
    $studentPattern = '/^[0-9]{2}-[0-9]{4}$/';

    // Staff/Instructor ID format: EMP-XXXX (e.g., EMP-2043)
    $staffPattern = '/^EMP-[0-9]{4}$/';

    if ($userRole === 'Student') {
      return preg_match($studentPattern, $userId);
    } else if ($userRole === 'Staff' || $userRole === 'Instructor') {
      return preg_match($staffPattern, $userId);
    }

    return false;
  }

  // Get all issues
  public function getAll()
  {
    $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
    $result = $this->conn->query($query);

    if ($result) {
      return $result->fetch_all(MYSQLI_ASSOC);
    }
    return [];
  }

  // Get single issue by ID
  public function getById($id)
  {
    $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
    $statement = $this->conn->prepare($query);
    $statement->bind_param("i", $id);
    $statement->execute();
    $result = $statement->get_result();

    return $result->fetch_assoc();
  }

  // Create new issue
  public function create($data)
  {
    // Validate User ID before inserting
    if (!$this->validateUserId($data['user_id'], $data['user_role'])) {
      return false;
    }

    $query = "INSERT INTO " . $this->table . " 
                  (user_id, user_role, title, description, category, location, image) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

    $statement = $this->conn->prepare($query);
    $statement->bind_param(
      "sssssss",
      $data['user_id'],
      $data['user_role'],
      $data['title'],
      $data['description'],
      $data['category'],
      $data['location'],
      $data['image']
    );

    if ($statement->execute()) {
      return true;
    }
    return false;
  }

  // Update issue
  public function update($id, $data)
  {
    // Validate User ID before updating
    if (!$this->validateUserId($data['user_id'], $data['user_role'])) {
      return false;
    }

    $query = "UPDATE " . $this->table . " 
                  SET user_id = ?, user_role = ?, title = ?, description = ?, 
                      category = ?, location = ?, image = ? 
                  WHERE id = ?";

    $statement = $this->conn->prepare($query);
    $statement->bind_param(
      "sssssssi",
      $data['user_id'],
      $data['user_role'],
      $data['title'],
      $data['description'],
      $data['category'],
      $data['location'],
      $data['image'],
      $id
    );

    return $statement->execute();
  }

  // Update status only
  public function updateStatus($id, $status)
  {
    $query = "UPDATE " . $this->table . " SET status = ? WHERE id = ?";
    $statement = $this->conn->prepare($query);
    $statement->bind_param("si", $status, $id);

    return $statement->execute();
  }

  // Delete issue
  public function delete($id)
  {
    // Get image first to delete file
    $issue = $this->getById($id);
    if ($issue && $issue['image']) {
      $imagePath = __DIR__ . '/../../public/uploads/' . $issue['image'];
      if (file_exists($imagePath)) {
        unlink($imagePath);
      }
    }

    $query = "DELETE FROM " . $this->table . " WHERE id = ?";
    $statement = $this->conn->prepare($query);
    $statement->bind_param("i", $id);

    return $statement->execute();
  }

  // Get issue count by status
  public function getCountByStatus($status)
  {
    $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE status = ?";
    $statement = $this->conn->prepare($query);
    $statement->bind_param("s", $status);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    return $row['count'];
  }

  // Get issue count by category
  public function getCountByCategory($category)
  {
    $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE category = ?";
    $statement = $this->conn->prepare($query);
    $statement->bind_param("s", $category);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    return $row['count'];
  }

  // Get issue count by user role
  public function getCountByUserRole($role)
  {
    $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE user_role = ?";
    $statement = $this->conn->prepare($query);
    $statement->bind_param("s", $role);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    return $row['count'];
  }

  // Search and filter issues
  public function searchAndFilter($searchTerm = '', $status = '', $category = '', $userRole = '')
  {
    $query = "SELECT * FROM " . $this->table . " WHERE 1=1";
    $params = [];
    $types = '';

    // Search by title, description, location, or user_id
    if (!empty($searchTerm)) {
      $query .= " AND (title LIKE ? OR description LIKE ? OR location LIKE ? OR user_id LIKE ?)";
      $searchParam = '%' . $searchTerm . '%';
      $params[] = $searchParam;
      $params[] = $searchParam;
      $params[] = $searchParam;
      $params[] = $searchParam;
      $types .= 'ssss';
    }

    // Filter by status
    if (!empty($status)) {
      $query .= " AND status = ?";
      $params[] = $status;
      $types .= 's';
    }

    // Filter by category
    if (!empty($category)) {
      $query .= " AND category = ?";
      $params[] = $category;
      $types .= 's';
    }

    // Filter by user role
    if (!empty($userRole)) {
      $query .= " AND user_role = ?";
      $params[] = $userRole;
      $types .= 's';
    }

    $query .= " ORDER BY created_at DESC";

    $statement = $this->conn->prepare($query);

    if (!empty($params)) {
      $statement->bind_param($types, ...$params);
    }

    $statement->execute();
    $result = $statement->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
  }
}
