<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('includes/db.php');
$products = $conn->query("SELECT * FROM produits")->fetchAll();
?>
<?php
require_once('includes/db.php');
$products = $conn->query("SELECT * FROM produits")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Football Shoes - Products</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include('includes/header.php'); ?>

    <div class="container">
        <h2>Our Football Shoes</h2>
        <div class="product-grid">
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <img src="images/<?= $p['image'] ?>" alt="<?= $p['nom'] ?>">
                    <h4><?= htmlspecialchars($p['nom']) ?></h4>
                    <p><?= number_format($p['prix'], 2) ?> TND</p>
                    <a href="product.php?id=<?= $p['id'] ?>" class="btn">Learn More</a>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="margin-top: 30px;">
            <a href="javascript:history.back()" class="btn">← Go Back</a>
            <a href="index.php" class="btn" style="margin-left: 10px;">🏠 Go to Home</a>
        </div>

    </div>
</body>
</html>
