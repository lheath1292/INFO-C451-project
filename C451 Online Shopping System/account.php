<?php
include 'header.php';
include 'functions.php';

$error = "";
$success = "";

// Handle login request
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (login($username, $password)) {
        $success = "Login successful!";
    } else {
        $error = "Invalid username or password.";
    }
}

// Handle registration request
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    if (register($username, $password, $email)) {
        $success = "Registration successful! You can now log in.";
    } else {
        $error = "Username already exists.";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    logout();
    $success = "Logged out successfully!";
}

?>

<div class="account">
    <?php if (!isset($_SESSION['user'])): ?>
        <!-- Login Form -->
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <h3>OR</h3>

        <!-- Registration Form -->
        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit" name="register">Register</button>
        </form>

        <!-- Display Errors -->
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

    <?php else: ?>
        <!-- If User is Logged In -->
        <h2>Welcome, <?php echo $_SESSION['user']; ?>!</h2>
        <p>Email: <?php echo $users[$_SESSION['user']]['email']; ?></p>
        <a href="account.php?logout=true">Logout</a>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
