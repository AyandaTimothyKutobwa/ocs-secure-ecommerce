<?php
session_start();
require 'config.php';

if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .add-btn {
            display: block;
            width: fit-content;
            margin: 0 auto 30px;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .add-btn:hover {
            background-color: #0056b3;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
        }
        .product-card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease;
        }
        .product-card:hover {
            transform: scale(1.02);
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .product-content {
            padding: 15px;
        }
        .product-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .product-desc {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .product-price {
            font-size: 16px;
            color: #28a745;
            margin-bottom: 15px;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            padding: 0 15px 15px 15px;
        }
        .actions a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .actions a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🛍️ Product Inventory</h2>
    <a class="add-btn" href="add_product.php">+ Add New Product</a>

    <div class="products-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img class="product-image" src="assets/<?= htmlspecialchars($row['image']) ?>" alt="Product Image">
                    <div class="product-content">
                        <div class="product-title"><?= htmlspecialchars($row['name']) ?></div>
                        <div class="product-desc"><?= htmlspecialchars($row['description']) ?></div>
                        <div class="product-price">$<?= htmlspecialchars($row['price']) ?></div>
                    </div>
                    <div class="actions">
                        <a href="edit_product.php?id=<?= $row['id'] ?>">✏️ Edit</a>
                        <a href="delete_product.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this product?');">🗑️ Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center;">No products found in the inventory.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
