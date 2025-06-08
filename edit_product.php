<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;

    $image = $_FILES['image']['name'] ?? '';
    $target_dir = "assets/";

    if ($image) {
        $target_file = $target_dir . basename($image);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // File uploaded successfully
        } else {
            echo "❌ Failed to upload image.";
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $description, $price, $image);
    $stmt->execute();

    header("Location: products_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background:#f7f7f7; }
        form { background: white; padding: 20px; border-radius: 5px; max-width: 400px; }
        input, textarea { width: 100%; margin-bottom: 10px; padding: 10px; }
        button { background: #28a745; color: white; padding: 10px; border: none; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>

<h1>Add New Product</h1>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required>
    <textarea name="description" placeholder="Product Description" required></textarea>
    <input type="number" step="0.01" name="price" placeholder="Price" required>
    <input type="file" name="image" required>
    <button type="submit">Add Product</button>
</form>

<a href="products_dashboard.php">← Back to Dashboard</a>

</body>
</html>
