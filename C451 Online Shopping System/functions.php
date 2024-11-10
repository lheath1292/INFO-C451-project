<?php

// Include database connection file
include('db_connect.php');

// Function to get all products from the database
function getProducts() {
    global $pdo;

    // Fetch all products from the database
    $stmt = $pdo->query("SELECT * FROM products");
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return products as an associative array
}

// Function to add a product to the cart
function addToCart($productId, $quantity) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Initialize cart if it doesn't exist
    }

    // Check if the product is already in the carts
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity; // Increase the quantity if the product is already in the cart
    } else {
        $_SESSION['cart'][$productId] = $quantity; // Add the product to the cart if it's not already there
    }
}

// Function to remove a product from the cart
function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]); // Remove the product from the cart
    }
}

// Function to get the items in the cart
function getCart() {
    $cart = [];
    if (isset($_SESSION['cart'])) {
        global $pdo;
        
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            // Fetch product details from the database
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->execute(['id' => $productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                $cart[] = [
                    'id' => $productId,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity,
                    'total' => $product['price'] * $quantity
                ];
            }
        }
    }
    return $cart;
}

// Function to get the cart's total price
function getCartTotal() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        global $pdo;
        
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $stmt = $pdo->prepare("SELECT price FROM products WHERE id = :id");
            $stmt->execute(['id' => $productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                $total += $product['price'] * $quantity; // Calculate total price based on quantity and price
            }
        }
    }
    return $total;
}

// Function to clear the cart
function clearCart() {
    unset($_SESSION['cart']); // Clear the entire cart
}

// Function to handle user login
function login($username, $password) {
    // In a real application, you would check the username and password against a database
    if ($username == 'admin' && $password == 'password123') { // Simple hardcoded check for demonstration
        $_SESSION['user'] = $username; // Set session for logged-in user
        return true;
    }
    return false; // Return false if login failed
}

// Function to handle user logout
function logout() {
    unset($_SESSION['user']); // Clear the user session
}

// Function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['user']); // Check if a user is logged in
}
?>
