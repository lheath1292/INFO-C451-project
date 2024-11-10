<!DOCTYPE html>
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
        <a href="cart.php">Cart (<?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>)</a>
        <a href="account.php">Account</a>
    </div>
</header>

