<?php
require_once "config.php";
require_once "lib/GoogleAuthenticator.php";

$ga = new PHPGangsta_GoogleAuthenticator();

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($username) || empty($email) || empty($password)) {
        $error = "Please fill in all required fields.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            // Generate 2FA secret
            $twofa_secret = $ga->createSecret();

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, twofa_secret, is_approved) VALUES (?, ?, ?, 'user', ?, 1)");
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $twofa_secret);

            if ($stmt->execute()) {
                $success = "Registration successful. Scan the QR code below with Google Authenticator.";

                // Prepare QR code URL
                $qrCodeUrl = $ga->getQRCodeGoogleUrl('OCS Secure (' . $email . ')', $twofa_secret);
            } else {
                $error = "Error during registration. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - OCS Secure</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<h2>Register</h2>
<?php if($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if($success): ?>
    <div class="success"><?= htmlspecialchars($success) ?></div>
    <p>Open your Google Authenticator app and scan this QR code:</p>
    <img src="<?= htmlspecialchars($qrCodeUrl) ?>" alt="Scan QR code for 2FA">
    <p><a href="login.php">Go to Login</a></p>
<?php else: ?>
<form method="POST" action="">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Register</button>
</form>
<?php endif; ?>
</body>
</html>
