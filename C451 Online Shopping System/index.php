<?php
// Include the database connection
include('db_connect.php');

// Fetch trending items (Top 5 by views)
$query_trending = "SELECT * FROM products WHERE is_trending = TRUE ORDER BY views DESC LIMIT 5";
$stmt_trending = $pdo->query($query_trending);
$trending_items = $stmt_trending->fetchAll();

// Fetch popular items (Top 5 by ratings_count)
$query_popular = "SELECT * FROM products WHERE is_popular = TRUE ORDER BY ratings_count DESC LIMIT 5";
$stmt_popular = $pdo->query($query_popular);
$popular_items = $stmt_popular->fetchAll();

// Fetch best-selling items (Top 5 by total_sales)
$query_best_selling = "SELECT * FROM products WHERE is_best_selling = TRUE ORDER BY total_sales DESC LIMIT 5";
$stmt_best_selling = $pdo->query($query_best_selling);
$best_selling_items = $stmt_best_selling->fetchAll();

include 'header.php';
include 'functions.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>



<section id="trending">
    <h2>Trending Items</h2>
    <div class="product-list">
        <?php foreach ($trending_items as $item): ?>
            <div class="product-item">
                <img src="<?= $item['image_url']; ?>" alt="<?= $item['name']; ?>" class="product-image">
                <h3><?= $item['name']; ?></h3>
                <p><?= $item['description']; ?></p>
                <p><strong>$<?= $item['price']; ?></strong></p>
                <p>Views: <?= $item['views']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>


<section id="popular">
    <h2>Popular Items</h2>
    <div class="product-list">
        <?php foreach ($popular_items as $item): ?>
            <div class="product-item">
                <img src="<?= $item['image_url']; ?>" alt="<?= $item['name']; ?>" class="product-image">
                <h3><?= $item['name']; ?></h3>
                <p><?= $item['description']; ?></p>
                <p><strong>$<?= $item['price']; ?></strong></p>
                <p>Ratings: <?= $item['ratings_count']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>


<section id="best-selling">
    <h2>Best-Selling Items</h2>
    <div class="product-list">
        <?php foreach ($best_selling_items as $item): ?>
            <div class="product-item">
                <img src="<?= $item['image_url']; ?>" alt="<?= $item['name']; ?>" class="product-image">
                <h3><?= $item['name']; ?></h3>
                <p><?= $item['description']; ?></p>
                <p><strong>$<?= $item['price']; ?></strong></p>
                <p>Sales: <?= $item['total_sales']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Footer -->
<footer>
    <?php include('footer.php'); ?>
</footer>

</body>
</html>
