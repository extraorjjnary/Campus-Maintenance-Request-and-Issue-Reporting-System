<?php

/**
 * Issue Model - PDO Version
 * Handles all database operations for issues
 */

class Issue
{
  private $conn;
  private $table = 'issues';

  public function __construct($db)
  {
    $this->conn = $db;
  }

  /**
   * Get all issues for DataTables
   * @return array All issues with formatted data
   */
  public function getAll()
  {
    $query = "SELECT 
                    id,
                    user_id,
                    user_role,
                    title,
                    description,
                    category,
                    location,
                    image,
                    status,
                    DATE_FORMAT(created_at, '%M %d, %Y') as created_date,
                    created_at
                  FROM " . $this->table . "
                  ORDER BY created_at DESC";

    try {
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      return [];
    }
  }

  /**
   * Get single issue by ID
   * @param int $id Issue ID
   * @return array|null Issue data or null
   */
  public function getById($id)
  {
    $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";

    try {
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch();
    } catch (PDOException $e) {
      return null;
    }
  }

  /**
   * Create new issue
   * @param array $data Issue data
   * @return bool Success status
   */
  public function create($data)
  {
    $query = "INSERT INTO " . $this->table . "
                  (user_id, user_role, title, description, category, location, image)
                  VALUES (:user_id, :user_role, :title, :description, :category, :location, :image)";

    try {
      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':user_id', $data['user_id']);
      $stmt->bindParam(':user_role', $data['user_role']);
      $stmt->bindParam(':title', $data['title']);
      $stmt->bindParam(':description', $data['description']);
      $stmt->bindParam(':category', $data['category']);
      $stmt->bindParam(':location', $data['location']);
      $stmt->bindParam(':image', $data['image']);

      return $stmt->execute();
    } catch (PDOException $e) {
      return false;
    }
  }

  /**
   * Update issue
   * @param int $id Issue ID
   * @param array $data Updated data
   * @return bool Success status
   */
  public function update($id, $data)
  {
    $query = "UPDATE " . $this->table . "
                  SET user_id = :user_id,
                      user_role = :user_role,
                      title = :title,
                      description = :description,
                      category = :category,
                      location = :location,
                      image = :image
                  WHERE id = :id";

    try {
      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':user_id', $data['user_id']);
      $stmt->bindParam(':user_role', $data['user_role']);
      $stmt->bindParam(':title', $data['title']);
      $stmt->bindParam(':description', $data['description']);
      $stmt->bindParam(':category', $data['category']);
      $stmt->bindParam(':location', $data['location']);
      $stmt->bindParam(':image', $data['image']);

      return $stmt->execute();
    } catch (PDOException $e) {
      return false;
    }
  }

  /**
   * Update issue status only
   * @param int $id Issue ID
   * @param string $status New status
   * @return bool Success status
   */
  public function updateStatus($id, $status)
  {
    $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";

    try {
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':status', $status);
      return $stmt->execute();
    } catch (PDOException $e) {
      return false;
    }
  }

  /**
   * Delete issue
   * @param int $id Issue ID
   * @return bool Success status
   */
  public function delete($id)
  {
    // Get image filename before deleting
    $issue = $this->getById($id);

    $query = "DELETE FROM " . $this->table . " WHERE id = :id";

    try {
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

      if ($stmt->execute()) {
        // Delete image file if exists
        if ($issue && $issue['image']) {
          $imagePath = __DIR__ . '/../../public/uploads/' . $issue['image'];
          if (file_exists($imagePath)) {
            unlink($imagePath);
          }
        }
        return true;
      }
      return false;
    } catch (PDOException $e) {
      return false;
    }
  }

  /**
   * Get issue count by status
   * @param string $status Status to count
   * @return int Count
   */
  public function getCountByStatus($status)
  {
    $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE status = :status";

    try {
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->execute();
      $result = $stmt->fetch();
      return $result['count'];
    } catch (PDOException $e) {
      return 0;
    }
  }

  /**
   * Validate User ID format
   * @param string $userId User ID
   * @param string $userRole User role
   * @return bool Valid or not
   */
  public function validateUserId($userId, $userRole)
  {
    $patterns = [
      'Student' => '/^[0-9]{2}-[0-9]{4}$/',
      'Staff' => '/^EMP-[0-9]{4}$/',
      'Instructor' => '/^EMP-[0-9]{4}$/'
    ];

    return isset($patterns[$userRole]) && preg_match($patterns[$userRole], $userId);
  }
}
