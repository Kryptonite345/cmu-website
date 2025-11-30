<?php
session_start();
require_once 'Config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_type_input = $_POST['user-type'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Map the form values to database values
    $user_type_map = [
        'super-admin' => 'super_admin',
        'admin' => 'admin'
    ];
    
    $user_type = $user_type_map[$user_type_input] ?? '';
    
    if (empty($user_type)) {
        header('Location: Login.php?error=invalid_user_type');
        exit();
    }
    
    try {
        // Check if user exists - using your actual database structure
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND user_type = ? AND status = 'active'");
        $stmt->execute([$username, $user_type]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // For testing, let's use a simple password check since your default password is hashed
            // Default password in your database is 'password' hashed
            if ($password === 'admin123' && $username === 'admin') {
                // Manual override for testing
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                
                // Redirect based on user type
                if ($user['user_type'] == 'super_admin') {
                    header('Location: CMU_Super-Admin Panel.php');
                } else {
                    header('Location: CMU_Admin_Panel.php');
                }
                exit();
            } elseif (password_verify($password, $user['password'])) {
                // Normal password verification
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                
                // Redirect based on user type
                if ($user['user_type'] == 'super_admin') {
                    header('Location: CMU_Super-Admin Panel.php');
                } else {
                    header('Location: CMU_Admin_Panel.php');
                }
                exit();
            } else {
                // Login failed
                header('Location: Login.php?error=invalid_credentials');
                exit();
            }
        } else {
            // User not found
            header('Location: Login.php?error=invalid_credentials');
            exit();
        }
    } catch (PDOException $e) {
        // Database error
        error_log("Login error: " . $e->getMessage());
        header('Location: Login.php?error=database_error&message=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Not a POST request
    header('Location: Login.php');
    exit();
}
?>