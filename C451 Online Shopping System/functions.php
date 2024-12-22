<?php

// Include database connection file

include('db_connect.php');
include 'header.php';

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

    // Fetch product details from the database
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$productId])) {
            // Increase the quantity if the product is already in the cart
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            // Add the product to the cart if it's not already there
            $_SESSION['cart'][$productId] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'image_url' => $product['image_url']
            ];
        }
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
        foreach ($_SESSION['cart'] as $productId => $item) {
            // Prepare the cart item with additional fields
            $cart[] = [
                'id' => $productId,
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
                'image_url' => $item['image_url']
            ];
        }
    }
    return $cart;
}

// Function to get the cart's total price
function getCartTotal() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productId => $item) {
            $total += $item['price'] * $item['quantity']; // Calculate total price based on quantity and price
        }
    }
    return $total;
}

// Function to clear the cart
function clearCart() {
    unset($_SESSION['cart']); // Clear the entire cart
}

// Function to handle user login
function login($email, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE LOWER(email) = LOWER(:email)");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['user_id'] = $user['id'];
        return true;
    } else {
        error_log('Password mismatch for user: ' . $email);  // Logs the issue
        die('Password mismatch.');  // Debugging line
    }
    }
    return false;
}



// Function to handle user logout
function logout() {
    unset($_SESSION['user']); // Clear the user session
}

// Function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['user']); // Check if a user is logged in
}


// User Registration
function register($firstName, $lastName, $password, $email) {
    global $pdo;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, password, email) 
                               VALUES (:first_name, :last_name, :password, :email)");
        $stmt->execute([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'password' => $hashedPassword,
            'email' => $email
        ]);
        return true;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {  // Duplicate entry
            return false;
        }
        throw $e;
    }
}


function placeOrder($userId) {
    global $pdo;

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return false;  // No items in cart
    }

    $totalAmount = getCartTotal();  // Calculate total cart amount

    try {
        // Insert new order into orders table
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount) VALUES (:user_id, :total_amount)");
        $stmt->execute([
            'user_id' => $userId,
            'total_amount' => $totalAmount
        ]);

        // Get the last inserted order ID
        $orderId = $pdo->lastInsertId();

        // Insert each item into order_items table (if exists)
        foreach ($_SESSION['cart'] as $productId => $item) {
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) 
                                  VALUES (:order_id, :product_id, :quantity, :price)");
            $stmt->execute([
                'order_id' => $orderId,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        // Clear the cart after placing order
        clearCart();
        return true;
    } catch (PDOException $e) {
        error_log("Order Error: " . $e->getMessage());
        return false;
    }
}


?>
