<?php
session_start(); 
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyThings</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<header>
    <div class="header-left">
        <a href="index.php">BuyThings</a>
    </div>
    <div class="header-center">
        <form action="search.php" method="GET" class="search-form">
            <input type="text" name="query" placeholder="Search products..." class="search-bar" required>
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>
    <div class="header-right">
        <?php
      
        $cartItemCount = 0;
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
         
            foreach ($_SESSION['cart'] as $item) {
                if (isset($item['quantity'])) {
                    $cartItemCount += $item['quantity'];
                }
            }
        }
        ?>
        <a href="cart.php">Cart (<?php echo $cartItemCount; ?>)</a>
        <a href="account.php">Account</a>
    </div>
</header>
