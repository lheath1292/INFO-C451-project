<?php

// Include the database connection and functions
include('db_connect.php');
include('functions.php');  // Assuming your cart functions are in this file

// Get the cart items and total price
$cartItems = getCart();  // Fetches the items in the cart from the session
$cartTotal = getCartTotal();  // Calculates the total price of the cart

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('header.php'); ?> 

<div class="cart-container">
    <h2>Your Cart</h2>

    <?php if (count($cartItems) > 0): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['total'], 2); ?></td>
                        <td>
                            <a href="remove_from_cart.php?id=<?php echo $item['id']; ?>">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-total">
            <p><strong>Total: $<?php echo number_format($cartTotal, 2); ?></strong></p>
        </div>
        
        <a href="checkout.php" class="btn checkout-btn">Proceed to Checkout</a>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?> 

</body>
</html>
