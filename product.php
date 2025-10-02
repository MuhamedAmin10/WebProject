<?php
require_once('includes/db.php');

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "Product not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($product['nom']) ?> - Details</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include('includes/header.php'); ?>

    <div class="container">
        <h2><?= htmlspecialchars($product['nom']) ?></h2>
        <img src="images/<?= $product['image'] ?>" alt="<?= $product['nom'] ?>" width="300">
        <p><strong>Price:</strong> <?= number_format($product['prix'], 2) ?> TND</p>
        <p><strong>Size:</strong> <?= $product['taille'] ?></p>
        <p><strong>Stock:</strong> <?= $product['stock'] ?> available</p>
        <p><strong>Description:</strong></p>
        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

        <div style="margin-top: 30px;">
            <a href="products.php" class="btn">← Back to Products</a>
            <a href="javascript:history.back()" class="btn" style="margin-left: 10px;">← Go Back</a>
        </div>

</body>
</html>
