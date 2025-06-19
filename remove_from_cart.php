<?php
session_start();
include('./backend/connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php?error=login_required");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cart_id = intval($_GET['id']); // Ensure it's an integer
    $user_id = $_SESSION['user_id'];

    // Debugging: Check received values
    error_log("Attempting to remove cart item: Cart ID = $cart_id, User ID = $user_id");

    // Verify if the cart item belongs to the logged-in user
    $checkQuery = "SELECT id FROM cart WHERE id = ? AND user_id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    if (!$checkStmt) {
        die("SQL Error: " . $conn->error);
    }
    $checkStmt->bind_param("ii", $cart_id, $user_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // If item exists, proceed with deletion
        $query = "DELETE FROM cart WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }

        $stmt->bind_param("ii", $cart_id, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Product removed from cart!";
        } else {
            $_SESSION['error'] = "Failed to remove product from cart!";
        }
    } else {
        $_SESSION['error'] = "Invalid request! Cart item not found.";
    }

    // Redirect back to cart
    header("Location: cart.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request!";
    header("Location: cart.php");
    exit();
}
