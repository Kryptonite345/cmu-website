<?php
session_start();

// Check if user is logged in and is super admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'super_admin') {
    header('Location: Login.html');
    exit();
}

// First, try to connect without database to check if it exists
$host = 'localhost';
$username = 'root';
$password = 'dave090935715919*';

try {
    // Try to connect without database first
    $temp_pdo = new PDO("mysql:host=$host", $username, $password);
    $temp_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if database exists
    $result = $temp_pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'cmu_management'");
    $databaseExists = $result->fetch(PDO::FETCH_ASSOC);
    
    if (!$databaseExists) {
        // Database doesn't exist, create it
        $temp_pdo->exec("CREATE DATABASE cmu_management");
        $temp_pdo->exec("USE cmu_management");
        
        // Create tables
        $temp_pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            user_type ENUM('admin', 'super_admin') NOT NULL,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        $temp_pdo->exec("CREATE TABLE IF NOT EXISTS enrollments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            program_applied VARCHAR(100) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            given_name VARCHAR(50) NOT NULL,
            ext_name VARCHAR(10),
            gender ENUM('male', 'female') NOT NULL,
            civil_status VARCHAR(20) NOT NULL,
            birth_date DATE NOT NULL,
            birth_place VARCHAR(100) NOT NULL,
            nationality VARCHAR(50) NOT NULL,
            religion VARCHAR(50) NOT NULL,
            contact_no VARCHAR(20) NOT NULL,
            email_address VARCHAR(100) NOT NULL,
            address TEXT NOT NULL,
            residence VARCHAR(20) NOT NULL,
            indigenous_group ENUM('yes', 'no') NOT NULL,
            indigenous_details VARCHAR(100),
            father_name VARCHAR(100) NOT NULL,
            father_status ENUM('living', 'deceased') NOT NULL,
            father_occupation VARCHAR(50) NOT NULL,
            father_income DECIMAL(10,2) NOT NULL,
            father_contact VARCHAR(20) NOT NULL,
            mother_name VARCHAR(100) NOT NULL,
            mother_status ENUM('living', 'deceased') NOT NULL,
            mother_occupation VARCHAR(50) NOT NULL,
            mother_income DECIMAL(10,2) NOT NULL,
            mother_contact VARCHAR(20) NOT NULL,
            guardian_name VARCHAR(100) NOT NULL,
            guardian_relationship VARCHAR(50) NOT NULL,
            guardian_occupation VARCHAR(50) NOT NULL,
            guardian_income DECIMAL(10,2) NOT NULL,
            guardian_contact VARCHAR(20) NOT NULL,
            school_name VARCHAR(100) NOT NULL,
            school_address TEXT NOT NULL,
            lrn VARCHAR(20) NOT NULL,
            facebook_url VARCHAR(255) NOT NULL,
            profile_pic VARCHAR(255),
            documents VARCHAR(255),
            time_submitted TIME NOT NULL,
            signature_applicant VARCHAR(100) NOT NULL,
            signature_date DATE NOT NULL,
            submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'
        )");
        
        $temp_pdo->exec("CREATE TABLE IF NOT EXISTS courses (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            category VARCHAR(100),
            duration INT,
            price DECIMAL(10,2),
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        $temp_pdo->exec("CREATE TABLE IF NOT EXISTS news (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            content TEXT NOT NULL,
            category VARCHAR(100),
            status ENUM('published', 'draft') DEFAULT 'published',
            created_by INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        $temp_pdo->exec("CREATE TABLE IF NOT EXISTS contact_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            status ENUM('read', 'unread') DEFAULT 'unread',
            submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Insert default users
        $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
        $temp_pdo->exec("INSERT IGNORE INTO users (username, password, user_type, full_name, email) 
                        VALUES ('superadmin', '$hashed_password', 'super_admin', 'Super Administrator', 'superadmin@cmu.edu.ph')");
        $temp_pdo->exec("INSERT IGNORE INTO users (username, password, user_type, full_name, email) 
                        VALUES ('admin', '$hashed_password', 'admin', 'Administrator', 'admin@cmu.edu.ph')");
        
        // Insert sample courses
        $temp_pdo->exec("INSERT IGNORE INTO courses (title, description, category, duration, price) VALUES
                        ('Computer Science', 'Bachelor of Science in Computer Science', 'Technology', 48, 0),
                        ('Business Administration', 'Bachelor of Science in Business Administration', 'Business', 48, 0),
                        ('Education', 'Bachelor of Elementary Education', 'Education', 48, 0),
                        ('Engineering', 'Bachelor of Science in Civil Engineering', 'Engineering', 60, 0)");
        
        // Store success message in session to show after redirect
        $_SESSION['db_setup_success'] = true;
    }
    
} catch (PDOException $e) {
    die("Database setup failed: " . $e->getMessage());
}

// Now include the regular config
require_once 'Config.php';

// Show success message if database was just created
if (isset($_SESSION['db_setup_success']) && $_SESSION['db_setup_success']) {
    $db_success = "Database and tables created successfully! Default login: admin / admin123";
    unset($_SESSION['db_setup_success']);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle admin creation
    if (isset($_POST['add_admin'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $user_type = 'admin';
        
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password, user_type, full_name, email) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$username, $password, $user_type, $full_name, $email]);
            
            // Refresh to show new data
            header("Location: CMU_Super-Admin Panel.php");
            exit();
        } catch (PDOException $e) {
            $admin_error = "Error creating admin: " . $e->getMessage();
        }
    }
    // Handle enrollment status updates
if (isset($_POST['update_enrollment_status'])) {
    $enrollment_id = $_POST['enrollment_id'];
    $status = $_POST['status'];
    
    try {
        $stmt = $pdo->prepare("UPDATE enrollments SET status = ? WHERE id = ?");
        $stmt->execute([$status, $enrollment_id]);
        
        // Refresh to show updated data - FIXED URL
        header("Location: CMU_Super-Admin Panel.php");
        exit();
    } catch (PDOException $e) {
        $enrollment_error = "Error updating enrollment: " . $e->getMessage();
    }
}

// Handle enrollment deletion
if (isset($_POST['delete_enrollment'])) {
    $enrollment_id = $_POST['enrollment_id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM enrollments WHERE id = ?");
        $stmt->execute([$enrollment_id]);
        
        // Refresh to show updated data - FIXED URL
        header("Location: CMU_Super-Admin Panel.php");
        exit();
    } catch (PDOException $e) {
        $enrollment_error = "Error deleting enrollment: " . $e->getMessage();
    }
}
    // Handle news creation
    if (isset($_POST['add_news'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $status = 'published';
        
        try {
            $stmt = $pdo->prepare("INSERT INTO news (title, content, category, status, created_by) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $content, $category, $status, $_SESSION['user_id']]);
            
            // Refresh to show new data
            header("Location: CMU_Super-Admin Panel.php");
            exit();
        } catch (PDOException $e) {
            $news_error = "Error creating news: " . $e->getMessage();
        }
    }
    
    // Handle course creation
    if (isset($_POST['add_course'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $duration = $_POST['duration'];
        $price = $_POST['price'];
        $status = 'active';
        
        try {
            $stmt = $pdo->prepare("INSERT INTO courses (title, description, category, duration, price, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $category, $duration, $price, $status]);
            
            // Refresh to show new data
            header("Location: CMU_Super-Admin Panel.php");
            exit();
        } catch (PDOException $e) {
            $course_error = "Error creating course: " . $e->getMessage();
        }
    }
}

// Fetch data for dashboard with error handling
try {
    $enrollments_count = $pdo->query("SELECT COUNT(*) FROM enrollments")->fetchColumn();
    $courses_count = $pdo->query("SELECT COUNT(*) FROM courses WHERE status = 'active'")->fetchColumn();
    $feedback_count = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'unread'")->fetchColumn();
    $news_count = $pdo->query("SELECT COUNT(*) FROM news WHERE status = 'published'")->fetchColumn();
    $admins_count = $pdo->query("SELECT COUNT(*) FROM users WHERE user_type = 'admin' AND status = 'active'")->fetchColumn();

    $recent_enrollments = $pdo->query("SELECT * FROM enrollments ORDER BY submitted_at DESC LIMIT 5")->fetchAll();
    $recent_news = $pdo->query("SELECT * FROM news ORDER BY created_at DESC LIMIT 5")->fetchAll();
    $courses = $pdo->query("SELECT * FROM courses")->fetchAll();
    $feedback = $pdo->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC LIMIT 10")->fetchAll();
    $admins = $pdo->query("SELECT * FROM users WHERE user_type = 'admin'")->fetchAll();
} catch (PDOException $e) {
    // Handle database errors gracefully
    error_log("Database error: " . $e->getMessage());
    $enrollments_count = $courses_count = $feedback_count = $news_count = $admins_count = 0;
    $recent_enrollments = $recent_news = $courses = $feedback = $admins = [];
    $db_error = "Unable to load data. Please check database connection.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System - Super Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --info: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --sidebar-width: 250px;
            --header-height: 60px;
        }

        body {
            background-color: #f5f7fb;
            color: var(--dark);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
            color: white;
            height: 100vh;
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .sidebar-menu {
            padding: 15px 0;
        }

        .sidebar-menu ul {
            list-style: none;
        }

        .sidebar-menu li {
            padding: 12px 20px;
            transition: all 0.3s;
        }

        .sidebar-menu li.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid white;
        }

        .sidebar-menu li:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar-menu i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
        }

        /* Header Styles */
        .header {
            height: var(--header-height);
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left h1 {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .header-right {
            display: flex;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }

        /* Content Styles */
        .content {
            padding: 20px;
        }

        .page {
            display: none;
        }

        .page.active {
            display: block;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .card-header h2 {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            color: var(--primary);
            font-weight: 600;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-active {
            background-color: rgba(76, 201, 240, 0.2);
            color: var(--success);
        }

        .status-pending {
            background-color: rgba(248, 150, 30, 0.2);
            color: var(--warning);
        }

        .status-inactive {
            background-color: rgba(108, 117, 125, 0.2);
            color: #6c757d;
        }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            margin-right: 10px;
            font-size: 1rem;
        }

        .edit-btn {
            color: var(--info);
        }

        .delete-btn {
            color: var(--danger);
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* Dashboard Stats */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            align-items: center;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.5rem;
        }

        .stat-icon.enrollments {
            background-color: rgba(67, 97, 238, 0.2);
            color: var(--primary);
        }

        .stat-icon.courses {
            background-color: rgba(76, 201, 240, 0.2);
            color: var(--success);
        }

        .stat-icon.feedback {
            background-color: rgba(248, 150, 30, 0.2);
            color: var(--warning);
        }

        .stat-icon.news {
            background-color: rgba(247, 37, 133, 0.2);
            color: var(--danger);
        }

        .stat-icon.admins {
            background-color: rgba(72, 149, 239, 0.2);
            color: var(--info);
        }

        .stat-info h3 {
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .stat-info p {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Error and Success Messages */
        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-error {
            background-color: rgba(247, 37, 133, 0.1);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .alert-success {
            background-color: rgba(76, 201, 240, 0.1);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: white;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .modal-header h3 {
            color: var(--primary);
            font-size: 1.3rem;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6c757d;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }

            .sidebar-header h2, .sidebar-header p, .sidebar-menu span {
                display: none;
            }

            .sidebar-menu i {
                margin-right: 0;
                font-size: 1.5rem;
            }

            .sidebar-menu li {
                text-align: center;
                padding: 15px 0;
            }

            .main-content {
                margin-left: 70px;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>SUPER ADMIN</h2>
            <p>City of Malabon University</p>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="active" data-page="dashboard">
                    <a href="#"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
                </li>
                <li data-page="admin-management">
                    <a href="#"><i class="fas fa-users-cog"></i> <span>Admin Management</span></a>
                </li>
                <li data-page="enrollments">
                    <a href="#"><i class="fas fa-user-graduate"></i> <span>Enrollments</span></a>
                </li>
                <li data-page="feedback">
                    <a href="#"><i class="fas fa-comment-dots"></i> <span>Feedback</span></a>
                </li>
                <li data-page="news">
                    <a href="#"><i class="fas fa-newspaper"></i> <span>News</span></a>
                </li>
                <li data-page="courses">
                    <a href="#"><i class="fas fa-book"></i> <span>Courses</span></a>
                </li>
                <li>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>Super Admin Dashboard</h1>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="user-details">
                        <h4><?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'Super Admin'; ?></h4>
                        <p>Super Administrator</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Error Messages -->
            <?php if (isset($db_error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $db_error; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($admin_error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $admin_error; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($news_error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $news_error; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($course_error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $course_error; ?>
                </div>
            <?php endif; ?>

            <!-- Dashboard Page -->
            <div class="page active" id="dashboard">
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-icon enrollments">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?php echo $enrollments_count; ?></h3>
                            <p>Total Enrollments</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon courses">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?php echo $courses_count; ?></h3>
                            <p>Active Courses</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon feedback">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?php echo $feedback_count; ?></h3>
                            <p>New Feedback</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon news">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?php echo $news_count; ?></h3>
                            <p>News Articles</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon admins">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?php echo $admins_count; ?></h3>
                            <p>Active Admins</p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Recent Enrollments</h2>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Course</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_enrollments)): ?>
                                    <?php foreach($recent_enrollments as $enrollment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($enrollment['given_name'] . ' ' . ($enrollment['middle_name'] ? $enrollment['middle_name'] . ' ' : '') . $enrollment['last_name'] . ($enrollment['ext_name'] ? ' ' . $enrollment['ext_name'] : '')); ?></td>
                                        <td><?php echo htmlspecialchars($enrollment['program_applied']); ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($enrollment['submitted_at'])); ?></td>
                                        <td><span class="status status-<?php echo $enrollment['status']; ?>"><?php echo ucfirst($enrollment['status']); ?></span></td>
                                        <td>
                                            <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="empty-state">
                                            <i class="fas fa-user-graduate"></i>
                                            <p>No enrollments found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Admin Management Page -->
            <div class="page" id="admin-management">
                <div class="card">
                    <div class="card-header">
                        <h2>Add New Admin</h2>
                        <button class="btn btn-primary" id="add-admin-btn">Add Admin</button>
                    </div>
                    <div class="form-container">
                        <form id="admin-form" method="POST">
                            <input type="hidden" name="add_admin" value="1">
                            <div class="form-group">
                                <label for="admin-name">Full Name</label>
                                <input type="text" id="admin-name" name="full_name" class="form-control" placeholder="Enter admin full name" required>
                            </div>
                            <div class="form-group">
                                <label for="admin-email">Email Address</label>
                                <input type="email" id="admin-email" name="email" class="form-control" placeholder="Enter admin email" required>
                            </div>
                            <div class="form-group">
                                <label for="admin-username">Username</label>
                                <input type="text" id="admin-username" name="username" class="form-control" placeholder="Enter username" required>
                            </div>
                            <div class="form-group">
                                <label for="admin-password">Password</label>
                                <input type="password" id="admin-password" name="password" class="form-control" placeholder="Enter password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Admin Account</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Admin Accounts</h2>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="admin-table-body">
                                <?php if (!empty($admins)): ?>
                                    <?php foreach($admins as $admin): ?>
                                    <tr>
                                        <td>#A<?php echo str_pad($admin['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                        <td><?php echo htmlspecialchars($admin['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($admin['email']); ?></td>
                                        <td><?php echo htmlspecialchars($admin['username']); ?></td>
                                        <td><span class="status status-<?php echo $admin['status']; ?>"><?php echo ucfirst($admin['status']); ?></span></td>
                                        <td>
                                            <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="empty-state">
                                            <i class="fas fa-users-cog"></i>
                                            <p>No admin accounts found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Enrollments Page -->
            <div class="page" id="enrollments">
                <div class="card">
                    <div class="card-header">
                        <h2>Student Enrollments</h2>
                        <button class="btn btn-primary">Add Enrollment</button>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student Name</th>
                                    <th>Course</th>
                                    <th>Enrollment Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_enrollments)): ?>
                                    <?php foreach($recent_enrollments as $enrollment): ?>
                                    <tr>
                                        <td>#<?php echo str_pad($enrollment['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                        <td><?php echo htmlspecialchars($enrollment['given_name'] . ' ' . $enrollment['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($enrollment['program_applied']); ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($enrollment['submitted_at'])); ?></td>
                                        <td><span class="status status-<?php echo $enrollment['status']; ?>"><?php echo ucfirst($enrollment['status']); ?></span></td>
                                        <td>
                                            <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="empty-state">
                                            <i class="fas fa-user-graduate"></i>
                                            <p>No enrollments found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Feedback Page -->
            <div class="page" id="feedback">
                <div class="card">
                    <div class="card-header">
                        <h2>Student Feedback</h2>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($feedback)): ?>
                                    <?php foreach($feedback as $message): ?>
                                    <tr>
                                        <td>#F<?php echo str_pad($message['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                        <td><?php echo htmlspecialchars($message['name']); ?></td>
                                        <td><?php echo htmlspecialchars($message['email']); ?></td>
                                        <td><?php echo htmlspecialchars($message['subject']); ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($message['submitted_at'])); ?></td>
                                        <td><span class="status status-<?php echo $message['status']; ?>"><?php echo ucfirst($message['status']); ?></span></td>
                                        <td>
                                            <button class="action-btn edit-btn"><i class="fas fa-eye"></i></button>
                                            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="empty-state">
                                            <i class="fas fa-comment-dots"></i>
                                            <p>No feedback messages found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- News Page -->
            <div class="page" id="news">
                <div class="card">
                    <div class="card-header">
                        <h2>Create News</h2>
                        <button class="btn btn-primary" id="add-news-btn">Add News</button>
                    </div>
                    <div class="form-container">
                        <form id="news-form" method="POST">
                            <input type="hidden" name="add_news" value="1">
                            <div class="form-group">
                                <label for="news-title">News Title</label>
                                <input type="text" id="news-title" name="title" class="form-control" placeholder="Enter news title" required>
                            </div>
                            <div class="form-group">
                                <label for="news-content">News Content</label>
                                <textarea id="news-content" name="content" class="form-control" placeholder="Enter news content" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="news-category">Category</label>
                                <select id="news-category" name="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="general">General</option>
                                    <option value="academic">Academic</option>
                                    <option value="events">Events</option>
                                    <option value="announcements">Announcements</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Publish News</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Recent News</h2>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_news)): ?>
                                    <?php foreach($recent_news as $news): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($news['title']); ?></td>
                                        <td><?php echo ucfirst($news['category']); ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($news['created_at'])); ?></td>
                                        <td><span class="status status-<?php echo $news['status']; ?>"><?php echo ucfirst($news['status']); ?></span></td>
                                        <td>
                                            <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="empty-state">
                                            <i class="fas fa-newspaper"></i>
                                            <p>No news articles found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Courses Page -->
            <div class="page" id="courses">
                <div class="card">
                    <div class="card-header">
                        <h2>Add Course</h2>
                        <button class="btn btn-primary" id="add-course-btn">Add Course</button>
                    </div>
                    <div class="form-container">
                        <form id="course-form" method="POST">
                            <input type="hidden" name="add_course" value="1">
                            <div class="form-group">
                                <label for="course-title">Course Title</label>
                                <input type="text" id="course-title" name="title" class="form-control" placeholder="Enter course title" required>
                            </div>
                            <div class="form-group">
                                <label for="course-description">Course Description</label>
                                <textarea id="course-description" name="description" class="form-control" placeholder="Enter course description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="course-category">Category</label>
                                <select id="course-category" name="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="technology">Technology</option>
                                    <option value="business">Business</option>
                                    <option value="design">Design</option>
                                    <option value="science">Science</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="course-duration">Duration (weeks)</label>
                                <input type="number" id="course-duration" name="duration" class="form-control" placeholder="Enter course duration" required>
                            </div>
                            <div class="form-group">
                                <label for="course-price">Price ($)</label>
                                <input type="number" id="course-price" name="price" class="form-control" placeholder="Enter course price" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Course</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>All Courses</h2>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Category</th>
                                    <th>Duration</th>
                                    <th>Price</th>
                                    <th>Enrollments</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($courses)): ?>
                                    <?php foreach($courses as $course): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($course['title']); ?></td>
                                        <td><?php echo ucfirst($course['category']); ?></td>
                                        <td><?php echo $course['duration']; ?> weeks</td>
                                        <td>$<?php echo $course['price']; ?></td>
                                        <td>
                                            <?php 
                                            try {
                                                $enrollment_count = $pdo->prepare("SELECT COUNT(*) FROM enrollments WHERE program_applied = ?");
                                                $enrollment_count->execute([$course['title']]);
                                                echo $enrollment_count->fetchColumn();
                                            } catch (PDOException $e) {
                                                echo "0";
                                            }
                                            ?>
                                        </td>
                                        <td><span class="status status-<?php echo $course['status']; ?>"><?php echo ucfirst($course['status']); ?></span></td>
                                        <td>
                                            <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="empty-state">
                                            <i class="fas fa-book"></i>
                                            <p>No courses found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Navigation between pages
        document.addEventListener('DOMContentLoaded', function() {
            const menuItems = document.querySelectorAll('.sidebar-menu li');
            const pages = document.querySelectorAll('.page');
            
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    const targetPage = this.getAttribute('data-page');
                    
                    // Remove active class from all menu items and pages
                    menuItems.forEach(menuItem => menuItem.classList.remove('active'));
                    pages.forEach(page => page.classList.remove('active'));
                    
                    // Add active class to clicked menu item and target page
                    this.classList.add('active');
                    document.getElementById(targetPage).classList.add('active');
                });
            });

            // Delete button handlers
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this item?')) {
                        const row = this.closest('tr');
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.remove();
                        }, 300);
                    }
                });
            });
        });
    </script>
</body>
</html>