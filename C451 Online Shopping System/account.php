<?php
include 'functions.php';

$error = "";
$success = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (login($email, $password)) {
        $success = "Login successful!";
    } else {
        $error = "Invalid email or password.";
    }
}

if (isset($_POST['register'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    if (register($firstName, $lastName, $password, $email)) {
        $success = "Registration successful! You can now log in.";
    } else {
        $error = "Email already exists.";
    }
}

if (isset($_GET['logout'])) {
    logout();
    $success = "Logged out successfully!";
}


$accountDetails = [];
$orderHistory = [];
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT first_name, last_name, email, created_at FROM users WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $accountDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :id ORDER BY created_at DESC");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $orderHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="account">
    <div class="container">
        <div class="form-wrapper">
            <?php if (!isset($_SESSION['user'])): ?>
                <h2>Login</h2>
                <form method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login">Login</button>
                </form>

                <h3>OR</h3>

                <h2>Register</h2>
                <form method="POST">
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="register">Register</button>
                </form>

                <?php if ($error): ?>
                    <p class="error"> <?php echo $error; ?> </p>
                <?php endif; ?>

            <?php else: ?>
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($accountDetails['email'] ?? 'N/A'); ?></p>
                <p><strong>Member since:</strong> <?php echo htmlspecialchars($accountDetails['created_at'] ?? 'N/A'); ?></p>

                <h3>Order History</h3>
                <ul>
                    <?php if (!empty($orderHistory)): ?>
                        <?php foreach ($orderHistory as $order): ?>
                            <li>Order #<?php echo htmlspecialchars($order['id']); ?> - $<?php echo htmlspecialchars($order['total_amount']); ?> - <?php echo htmlspecialchars($order['created_at']); ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No orders yet.</li>
                    <?php endif; ?>
                </ul>
                <a href="account.php?logout=true" class="logout-button">Logout</a>
            <?php endif; ?>

            <?php if ($success): ?>
                <p class="success"> <?php echo $success; ?> </p>
            <?php endif; ?>
            <?php if ($error): ?>
                <p class="error"> <?php echo $error; ?> </p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
