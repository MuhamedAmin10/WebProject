<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
require_once('../includes/db.php');

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $taille = $_POST['taille'];
    $stock = $_POST['stock'];
    $imageName = $product['image']; // default: keep current image

    // If a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = "../images/";
        $newImage = time() . "_" . $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imagePath = $uploadDir . $newImage;

        if (move_uploaded_file($imageTmp, $imagePath)) {
            $imageName = $newImage;
        }
    }

    // Update product
    $stmt = $conn->prepare("UPDATE produits SET nom=?, description=?, prix=?, taille=?, stock=?, image=? WHERE id=?");
    $stmt->execute([$nom, $description, $prix, $taille, $stock, $imageName, $id]);

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="admin-container">
        <h2>Edit Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nom" value="<?= $product['nom'] ?>" required>
            <textarea name="description" required><?= $product['description'] ?></textarea>
            <input type="number" step="0.01" name="prix" value="<?= $product['prix'] ?>" required>
            <select name="taille" required>
                <?php for ($i = 40; $i <= 46; $i++): ?>
                    <option value="<?= $i ?>" <?= ($product['taille'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
            <p>Current Image:</p>
            <img src="../images/<?= $product['image'] ?>" width="150" alt="">
            <input type="file" name="image" accept="image/*">
            <button type="submit">Update Product</button>
        </form>
        <p><a href="dashboard.php" class="btn">Back to Dashboard</a></p>
    </div>
</body>
</html>
