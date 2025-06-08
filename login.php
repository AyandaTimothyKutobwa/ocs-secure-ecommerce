<?php
session_start();

require 'config.php';

if (isset($_SESSION['userid'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username_email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($usernameOrEmail) || empty($password)) {
        $error = 'Please enter username/email and password.';
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['userid'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Invalid password.';
            }
        } else {
            $error = 'User not found.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Secure E-Commerce | Login</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

  * {
    box-sizing: border-box;
  }
  body, html {
    height: 100%;
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .login-container {
    background: rgba(255, 255, 255, 0.95);
    padding: 40px 50px;
    border-radius: 15px;
    width: 380px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    text-align: center;
    transition: transform 0.3s ease;
  }
  .login-container:hover {
    transform: translateY(-10px);
  }
  h2 {
    margin-bottom: 30px;
    font-weight: 700;
    font-size: 28px;
    color: #2c5364;
    letter-spacing: 1.2px;
  }
  input[type="text"],
  input[type="password"] {
    width: 100%;
    padding: 14px 15px;
    margin-bottom: 25px;
    border: 1.8px solid #2c5364;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s ease;
  }
  input[type="text"]:focus,
  input[type="password"]:focus {
    border-color: #007bff;
    outline: none;
  }
  button {
    width: 100%;
    background: #007bff;
    border: none;
    padding: 15px;
    border-radius: 8px;
    color: white;
    font-weight: 700;
    font-size: 18px;
    cursor: pointer;
    letter-spacing: 1px;
    transition: background 0.3s ease;
  }
  button:hover {
    background: #0056b3;
  }
  .error {
    background-color: #ffdddd;
    color: #b32d2d;
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(179, 45, 45, 0.2);
  }
  .footer-text {
    margin-top: 15px;
    font-size: 14px;
    color: #555;
  }
  .footer-text a {
    color: #007bff;
    text-decoration: none;
  }
  .footer-text a:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<div class="login-container" role="main" aria-label="Login Form">
    <h2>Secure E-Commerce Login</h2>
    <?php if ($error): ?>
        <div class="error" role="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="" novalidate>
        <input type="text" name="username_email" placeholder="Username or Email" required autofocus aria-required="true" aria-label="Username or Email" />
        <input type="password" name="password" placeholder="Password" required aria-required="true" aria-label="Password" />
        <button type="submit" aria-label="Login">Login</button>
    </form>
    <div class="footer-text">
        Don't have an account? <a href="register.php">Register here</a>.
    </div>
</div>

</body>
</html>
