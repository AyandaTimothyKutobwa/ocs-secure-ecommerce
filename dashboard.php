<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit;
}

$username = htmlspecialchars($_SESSION['username']);
$role = htmlspecialchars($_SESSION['role']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Dashboard | Secure E-Commerce</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

  body, html {
    margin: 0;
    padding: 0;
    font-family: 'Roboto', sans-serif;
    background: #f0f2f5;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  header {
    background: linear-gradient(90deg, #0052D4 0%, #4364F7 100%);
    color: #fff;
    padding: 25px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
  }
  header h1 {
    font-weight: 700;
    font-size: 24px;
    margin: 0;
  }
  header nav a {
    color: white;
    font-weight: 600;
    margin-left: 30px;
    text-decoration: none;
    font-size: 16px;
    transition: color 0.3s ease;
  }
  header nav a:hover {
    color: #c0d3ff;
  }
  .logout-btn {
    background-color: #ff4d4d;
    border: none;
    padding: 10px 18px;
    border-radius: 7px;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  .logout-btn:hover {
    background-color: #cc0000;
  }
  main {
    flex-grow: 1;
    padding: 40px;
    max-width: 1100px;
    margin: 0 auto;
  }
  h2 {
    color: #0052D4;
    font-weight: 700;
    font-size: 32px;
    margin-bottom: 30px;
  }
  .card-container {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
  }
  .card {
    background: white;
    flex: 1 1 280px;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 6px 18px rgba(0, 82, 212, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    color: #0052D4;
    text-align: center;
    font-weight: 700;
    font-size: 22px;
  }
  .card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 82, 212, 0.25);
  }
  .welcome-text {
    font-size: 20px;
    margin-bottom: 40px;
    font-weight: 500;
  }
  @media (max-width: 700px) {
    .card-container {
      flex-direction: column;
    }
  }
</style>
</head>
<body>

<header>
    <h1>Secure E-Commerce Admin Panel</h1>
    <nav>
        <a href="user_management.php">User Management</a>
        <a href="activity_logs.php">Activity Logs</a>
        <a href="products_dashboard.php">Products</a>
        <a href="logout.php" class="logout-btn" role="button">Logout</a>
    </nav>
</header>

<main>
    <div class="welcome-text">Welcome, <?= $role === 'admin' ? 'Admin ' : '' ?><?= $username ?></div>

    <div class="card-container" role="list">
        <a href="user_management.php" class="card" role="listitem" aria-label="User Management">User Management</a>
        <a href="activity_logs.php" class="card" role="listitem" aria-label="Activity Logs">Activity Logs</a>
        <a href="products_dashboard.php" class="card" role="listitem" aria-label="Products">Products</a>
    </div>
</main>

</body>
</html>
