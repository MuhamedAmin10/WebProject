<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
require_once('../includes/db.php');

// Fetch all products
$products = $conn->query("SELECT * FROM produits")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Adjust if needed -->
</head>
<body>
    <div class="admin-container">
        <h2>Admin Dashboard</h2>

        <p><a href="add_product.php" class="btn">+ Add New Product</a></p>
        <p><a href="logout.php" class="btn" style="background: #999;">Logout</a></p>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Size</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nom']) ?></td>
                    <td><?= number_format($p['prix'], 2) ?> TND</td>
                    <td><?= $p['taille'] ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td>
                        <?php if (!empty($p['image'])): ?>
                            <img src="../images/<?= $p['image'] ?>" alt="" width="50">
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit_product.php?id=<?= $p['id'] ?>">Edit</a> |
                        <a href="delete_product.php?id=<?= $p['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
