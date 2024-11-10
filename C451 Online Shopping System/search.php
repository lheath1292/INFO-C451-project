<?php
// Include the database connection file
include('db_connect.php');

// Get the search query from the form (if it exists)
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // Prepare a SQL query to search products by name or description
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :query OR description LIKE :query");
    $stmt->execute(['query' => '%' . $searchQuery . '%']);  // Wildcards to match any part of the string
    $products = $stmt->fetchAll();
} else {
    // If no search query, fetch all products (optional)
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll();
}

// Include the header (this will now be shared across all pages)
include('header.php');
?>

<div class="product-list">
    <h2>Search Results</h2>
    <?php if (count($products) > 0): ?>
        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-item">
                    <!-- Display product image, handle missing image cases -->
                    <img src="images/<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                    
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p>Price: $<?php echo number_format($product['price'], 2); ?></p>
                    <p>Stock: <?php echo $product['stock_quantity']; ?> available</p>

                    <!-- Link to individual product page -->
                    <a href="product.php?id=<?php echo $product['id']; ?>" class="product-link">View Product</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No products found matching your search.</p>
    <?php endif; ?>
</div>

<!-- Footer Section -->
<footer>
    <p>&copy; 2024 Your Shop</p>
</footer>

</body>
</html>
