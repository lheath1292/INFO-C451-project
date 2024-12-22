<?php

include('db_connect.php');
include 'functions.php';


$query_popular = "SELECT * FROM products WHERE is_popular = TRUE ORDER BY ratings_count DESC LIMIT 5";
$stmt_popular = $pdo->query($query_popular);
$popular_items = $stmt_popular->fetchAll();


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


<section id="popular">
    <h2>Popular Items</h2>
    <div class="product-list">
        <?php foreach ($popular_items as $item): ?>
            <div class="product-item">
             
                <img src="<?= htmlspecialchars($item['image_url']); ?>" alt="<?= htmlspecialchars($item['name']); ?>" class="product-image">

            
                <h3>
                    <a href="product.php?id=<?= htmlspecialchars($item['id']); ?>">
                        <?= htmlspecialchars($item['name']); ?>
                    </a>
                </h3>

          
                <p><strong class="price">$<?= number_format($item['price'], 2); ?></strong></p>

               
                <p>Ratings: <?= htmlspecialchars($item['ratings_count']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>


<footer>
    <?php include('footer.php'); ?>
</footer>

</body>
</html>
