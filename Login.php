<?php
// Login.php - Converted from Login.html to handle error messages
session_start();

$error = $_GET['error'] ?? '';
$error_messages = [
    'invalid_credentials' => 'Invalid username or password.',
    'invalid_user_type' => 'Please select a valid user type.',
    'database_error' => 'Database error. Please try again.',
    'session_expired' => 'Your session has expired. Please login again.'
];

$success_messages = [
    'logout' => 'You have been successfully logged out.',
    'registered' => 'Registration successful. Please login.'
];

$message = '';
$message_type = '';

if ($error && isset($error_messages[$error])) {
    $message = $error_messages[$error];
    $message_type = 'error';
}

$success = $_GET['success'] ?? '';
if ($success && isset($success_messages[$success])) {
    $message = $success_messages[$success];
    $message_type = 'success';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - City of Malabon University</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Your existing CSS remains the same */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body.login-body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #002b5b, #005792);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            padding: 40px 35px;
            width: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .login-header h2 {
            color: #002b5b;
            margin-bottom: 8px;
            font-size: 1.5rem;
        }

        .login-header p {
            color: #666;
            font-size: 0.9rem;
        }

        .login-form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #005792;
            box-shadow: 0 0 0 3px rgba(0, 87, 146, 0.1);
        }

        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #005792;
        }

        .login-btn {
            width: 100%;
            background: #005792;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            transition: background 0.3s ease, transform 0.2s ease;
            margin-top: 10px;
        }

        .login-btn:hover {
            background: #003f63;
            transform: translateY(-2px);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .login-footer a {
            color: #005792;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #003f63;
            text-decoration: underline;
        }

        .login-footer p {
            margin-top: 10px;
            color: #666;
            font-size: 0.9rem;
        }

        /* Error Message Styling */
        .error-message {
            background-color: #fee;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 0.9rem;
        }

        .success-message {
            background-color: #e8f5e8;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 0.9rem;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 25px;
            }
            
            .login-header img {
                width: 80px;
                height: 80px;
            }
            
            .login-header h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body class="login-body">

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <!-- CMU Logo -->
                <img src="images/cmu logo.png" alt="CMU Logo">
                <h2>City of Malabon University</h2>
                <p>Admin Portal</p>
            </div>

            <!-- Error/Success Messages -->
            <?php if ($message): ?>
                <div class="<?php echo $message_type === 'error' ? 'error-message' : 'success-message'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form action="LoginProcess.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="user-type">Login As:</label>
                    <select id="user-type" name="user-type" required>
                        <option value="">-- Select User Type --</option>
                        <option value="super-admin">Super Admin</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <button type="button" class="toggle-password" id="togglePassword">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="login-btn">Log In</button>
            </form>

            <div class="login-footer">
                <a href="ForgotPassword.html">Forgot Password?</a>
                <p>Don't have an account? <a href="Signup.html">Sign up</a></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = togglePassword.querySelector('i');
            
            togglePassword.addEventListener('click', function() {
                // Toggle password visibility
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle eye icon
                if (type === 'text') {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            });
        });
    </script>

</body>
</html>