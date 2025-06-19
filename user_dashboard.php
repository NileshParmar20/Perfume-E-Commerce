<?php
session_start();
include('./backend/connection.php'); // Ensure this file exists

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php?error=login_required");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Fetch cart summary
$cartQuery = "SELECT SUM(cart.quantity) AS total_items, SUM(products.product_price * cart.quantity) AS total_amount
              FROM cart
              JOIN products ON cart.product_id = products.product_id
              WHERE cart.user_id = ?";
$cartStmt = $conn->prepare($cartQuery);
$cartStmt->bind_param("i", $user_id);
$cartStmt->execute();
$cartSummary = $cartStmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="./styles/userboard_settings.css">
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include('header.php'); ?> <!-- Include Header -->

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Welcome, <?= htmlspecialchars($user['name']); ?></h2>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <div class="profile-overview">
            
            <div class="profile-details">
                <p><strong>Name:</strong> <?= htmlspecialchars($user['name']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
            </div>
        </div>

        <div class="dashboard-cards">
            <div class="card">
                <i class="fas fa-shopping-cart"></i>
                <h4>Cart Summary</h4>
                <p><strong>Total Items:</strong> <?= $cartSummary['total_items'] ?? 0; ?></p>
                <p><strong>Total Amount:</strong> ₹<?= number_format($cartSummary['total_amount'] ?? 0, 2); ?></p>
                <a href="cart.php" class="card-btn">View Cart</a>
            </div>

            <div class="card">
                <i class="fas fa-user-cog"></i>
                <h4>Account Settings</h4>
                <p>Manage your account details</p>
                <a href="settings.php" class="card-btn">Edit Settings</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php include('footer.php'); ?> 