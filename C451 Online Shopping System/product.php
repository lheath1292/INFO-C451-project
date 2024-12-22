<?php
// product.php
include('db_connect.php');
include('header.php');


$productId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$product = [];

if ($productId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $productId]);
    $product = $stmt->fetch();
}

if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $cart = &$_SESSION['cart'];

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += 1;
    } else {
        $cart[$productId] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => 1,
            'image_url' => $product['image_url']
        ];
    }
    header("Location: product.php?id=$productId");
    exit();
}
?>

<div class="product-detail">
    <?php if ($product): ?>
        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
        <div class="product-description">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p class="price"><strong>Price:</strong> $<?= number_format($product['price'], 2) ?></p>
            <p><strong>Brand:</strong> <?= htmlspecialchars($product['brand']) ?></p>
            <p><strong>Description:</strong> <?= htmlspecialchars($product['description']) ?></p>
            <p><strong>Stock:</strong> <?= htmlspecialchars($product['stock_quantity']) ?> available</p>
            
            <form method="post" action="">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                <button type="submit" name="add_to_cart">Add to Cart</button>
            </form>
        </div>
    <?php else: ?>
        <p>Product not found.</p>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
