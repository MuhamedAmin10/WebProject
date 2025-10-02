<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
require_once('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $taille = $_POST['taille'];
    $stock = $_POST['stock'];

    // Handle image upload
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $uploadDir = "../images/";
    $imagePath = $uploadDir . basename($imageName);

    // Move the uploaded file
    if (move_uploaded_file($imageTmp, $imagePath)) {
        $stmt = $conn->prepare("INSERT INTO produits (nom, description, prix, taille, stock, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $description, $prix, $taille, $stock, $imageName]);

        header("Location: dashboard.php");
        exit();
    } else {
        echo "Image upload failed.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="admin-container">
        <h2>Add New Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nom" placeholder="Product Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="number" step="0.01" name="prix" placeholder="Price" required>
            <select name="taille" required>
                <option value="">Size</option>
                <?php for ($i = 40; $i <= 46; $i++) echo "<option value='$i'>$i</option>"; ?>
            </select>
            <input type="number" name="stock" placeholder="Stock Quantity" required>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit">Add Product</button>
        </form>
        <p><a href="dashboard.php" class="btn">Back to Dashboard</a></p>
    </div>
</body>
</html>
