<?php
include('db_connect.php');

$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';
$products = [];

if (!empty($searchQuery)) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :query OR description LIKE :query");
    $stmt->execute(['query' => "%$searchQuery%"]);
    $products = $stmt->fetchAll();
}

include('header.php');
?>

<div class="product-list">
    <h2>Search Results</h2>
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
                <div class="product-info">
                    <h3><a href="product.php?id=<?= htmlspecialchars($product['id']) ?>"><?= htmlspecialchars($product['name']) ?></a></h3>
					                    <p class="price">Price: $<?= number_format($product['price'], 2) ?></p>
                    <p>Brand: <?= htmlspecialchars($product['brand']) ?></p>

                    <p>Stock: <?= htmlspecialchars($product['stock_quantity']) ?> available</p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found matching your search.</p>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
