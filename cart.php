<?php
session_start();
include('./backend/connection.php'); // Ensure this file exists

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php?error=login_required");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items with product details
$query = "SELECT cart.id AS cart_id, cart.quantity, 
                 products.product_name, products.product_price, products.product_image 
          FROM cart 
          JOIN products ON cart.product_id = products.product_id 
          WHERE cart.user_id = ?";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>

<link rel="stylesheet" href="./styles/cart.css">

<?php include('header.php'); ?> <!-- Include header for consistency -->

<main class="cart-container">
    <h2 class="cart-title">Shopping Cart</h2>

    <?php if ($result->num_rows > 0): ?>
        <table class="cart-table">
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><img src="./product_imgs/<?= htmlspecialchars($row['product_image']); ?>" class="cart-img"></td>
                <td><?= htmlspecialchars($row['product_name']); ?></td>
                <td>₹<?= number_format($row['product_price'], 2); ?></td>
                <td><?= $row['quantity']; ?></td>
                <td>₹<?= number_format($row['product_price'] * $row['quantity'], 2); ?></td>
                <td><a href="remove_from_cart.php?id=<?= $row['cart_id']; ?>" class="remove-btn">Remove</a></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <div class="cart-actions">
            <a href="products.php" class="btn continue-shopping">Continue Shopping</a>
            <!-- <a href="checkout.php" class="btn checkout-btn">Proceed to Checkout</a> -->
        </div>
    <?php else: ?>
        <p class="empty-cart">Your cart is empty.</p>
        <a href="products.php" class="btn go-shop">Go to Products</a>
    <?php endif; ?>
</main>

<?php include('footer.php'); ?> <!-- Include footer for consistency -->
