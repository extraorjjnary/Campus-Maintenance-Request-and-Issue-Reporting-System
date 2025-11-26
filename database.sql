-- Create Database
CREATE DATABASE IF NOT EXISTS campus_maintenance;
USE campus_maintenance;

-- Create issues table with user information
CREATE TABLE IF NOT EXISTS issues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    user_role ENUM('Student', 'Staff', 'Instructor') NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL,
    image VARCHAR(255) NULL,
    status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_category (category),
    INDEX idx_user_role (user_role),
    INDEX idx_user_id (user_id)
);

-- Insert sample data for testing
INSERT INTO issues (user_id, user_role, title, description, category, location, status) VALUES
('23-4302', 'Student', 'Broken Window in Classroom', 'The window on the left side is cracked and poses safety risk', 'Infrastructure', 'Building A - Room 301', 'Pending'),
('EMP-2043', 'Staff', 'Leaking Faucet', 'Bathroom sink is constantly dripping water, wasting resources', 'Plumbing', 'Building B - Restroom 2F', 'In Progress'),
('22-1589', 'Student', 'Non-functional Projector', 'The projector does not turn on, affecting class presentations', 'Equipment', 'Building C - Room 205', 'Pending'),
('EMP-3012', 'Instructor', 'Broken Chair', 'Office chair has broken wheel and armrest', 'Furniture', 'Faculty Office - 3F', 'Completed'),
('24-5671', 'Student', 'Faulty Air Conditioner', 'AC unit making loud noise and not cooling properly', 'HVAC', 'Library - Reading Area', 'In Progress'),
('EMP-4521', 'Staff', 'Damaged Door Lock', 'Door lock is jammed and difficult to open', 'Infrastructure', 'Building D - Main Entrance', 'Pending');