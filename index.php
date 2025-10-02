<?php require_once('includes/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football4U - Home</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include('includes/header.php');

// ✅ Search logic
$search = $_GET['search'] ?? '';

if ($search) {
    $stmt = $conn->prepare("SELECT * FROM produits WHERE nom LIKE ?");
    $stmt->execute(["%$search%"]);
    $products = $stmt->fetchAll();
} else {
    $products = $conn->query("SELECT * FROM produits ORDER BY id DESC LIMIT 6")->fetchAll();
}
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h2>Top-Quality Football Shoes</h2>
        <p>Explore the latest collection and choose your perfect fit.</p>
        <a href="products.php" class="btn">View All Products</a>
    </div>
</section>

<!-- ✅ Search Bar -->
<section class="search-bar" style="text-align: center; margin-top: 30px;">
    <form method="GET">
        <input type="text" name="search" placeholder="Search for a shoe..." autocomplete="on" value="<?= htmlspecialchars($search) ?>" style="padding: 10px; width: 250px; border-radius: 5px; border: 1px solid #ccc;">
        <button type="submit" class="btn">Search</button>
    </form>
</section>

<!-- Featured Products (Dynamic) -->
<section class="featured-products">
    <h3 style="text-align:center;">
        <?= $search ? "Search Results for '$search'" : "Featured Shoes" ?>
    </h3>

    <div class="product-grid">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <img src="images/<?= $p['image'] ?>" alt="<?= htmlspecialchars($p['nom']) ?>">
                    <h4><?= htmlspecialchars($p['nom']) ?></h4>
                    <p>Price: <?= number_format($p['prix'], 2) ?> TND</p>
                    <a href="product.php?id=<?= $p['id'] ?>" class="btn">Learn More</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center;">No products found for your search.</p>
        <?php endif; ?>
    </div>
</section>

<?php include('includes/footer.php'); ?>

</body>
</html>
