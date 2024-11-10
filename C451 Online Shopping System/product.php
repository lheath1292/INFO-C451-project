<?php

include 'header.php';
include 'functions.php';

// Dummy product list (in a real application, this would come from a database)
$products = [
    1 => ['name' => 'Product 1', 'description' => 'This is product 1', 'price' => 20, 'image' => 'product1.jpg'],
    2 => ['name' => 'Product 2', 'description' => 'This is product 2', 'price' => 25, 'image' => 'product2.jpg'],
    3 => ['name' => 'Product 3', 'description' => 'This is product 3', 'price' => 30, 'image' => 'product3.jpg'],
];

// Get product ID from URL
$productId = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($productId && isset($products[$productId])) {
    $product = $products[$productId];
} else {
    echo "<p>Product not found.</p>";
    exit;
}
?>

<div class="product-detail">
    <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
    <h2><?php echo $product['name']; ?></h2>
    <p><?php echo $product['description']; ?></p>
    <p>Price: $<?php echo $product['price']; ?></p>
    
    <form method="POST">
        <button type="submit" name="addToCart" value="<?php echo $productId; ?>">Add to Cart</button>
    </form>
</div>

<?php
// Handle adding to cart
if (isset($_POST['addToCart'])) {
    $productId = (int)$_POST['addToCart'];
    $quantity = 1; // Default quantity of 1 when added from the product page
    addToCart($productId, $quantity); // Function from functions.php
    echo "<p>Product added to cart!</p>";
}

include 'footer.php';
?>