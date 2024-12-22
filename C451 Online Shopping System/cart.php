<?php

if (isset($_GET['clear_cart'])) {
    unset($_SESSION['cart']);
    header('Location: cart.php');
    exit();
}


include('db_connect.php');
include('functions.php');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = &$_SESSION['cart'];
$subtotal = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $productId = $_POST['product_id'] ?? null;

    if ($productId) {
        if ($_POST['action'] === 'update' && isset($_POST['quantity'])) {
            $newQuantity = max(1, (int)$_POST['quantity']);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $newQuantity;
            }
        } elseif ($_POST['action'] === 'remove') {
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
            }
        }
    }
}

foreach ($cart as $item) {
    $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
}

if (isset($_POST['checkout'])) {
    if (!isset($_SESSION['user_id'])) {
        $error = "You need to be logged in to place an order.";
    } else {
        if (placeOrder($_SESSION['user_id'])) {
            $success = "Order placed successfully!";
        } else {
            $error = "Failed to place order.";
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - Shop</title>
</head>
<body>

<section id="cart">
    <h2>Your Cart</h2>
    <?php if (!empty($cart)): ?>
        <div class="product-list">
            <?php foreach ($cart as $productId => $item): ?>
                <div class="product-item">
                    <img src="<?= htmlspecialchars($item['image_url'] ?? '') ?>" alt="<?= htmlspecialchars($item['name'] ?? 'Unknown Product') ?>">
                    <div>
                        <h3><?= htmlspecialchars($item['name'] ?? 'Unknown Product') ?></h3>
                        <p><strong>Price:</strong> $<?= number_format($item['price'] ?? 0, 2) ?></p>
                        <p>
                            <form method="post">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($productId) ?>">
                                <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity'] ?? 1) ?>" min="1">
                                <button type="submit" name="action" value="update">Update</button>
                            </form>
                        </p>
                        <p><strong>Total:</strong> $<?= number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) ?></p>
                        <form method="post">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($productId) ?>">
                            <button type="submit" name="action" value="remove">Remove</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="cart-subtotal">
            <h3>Subtotal: $<?= number_format($subtotal, 2) ?></h3>
        </div>
		
		<?php if (!empty($cart)): ?>
    <form method="POST">
        <button type="submit" name="checkout">Checkout</button>
    </form>
<?php endif; ?>

    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</section>
<?php include('footer.php'); ?>
