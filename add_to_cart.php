<?php
session_start();
include('./backend/connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php?error=login_required");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Validate inputs
    if ($product_id <= 0 || $quantity <= 0) {
        $_SESSION['error'] = "Invalid product or quantity.";
        header("Location: products.php");
        exit();
    }

    // Fetch product details from the database
    $query = "SELECT product_price, product_quantity FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        $_SESSION['error'] = "Product not found.";
        header("Location: products.php");
        exit();
    }

    // Check stock availability
    if ($quantity > $product['product_quantity']) {
        $_SESSION['error'] = "Only " . $product['product_quantity'] . " units available.";
        header("Location: products.php");
        exit();
    }

    $product_price = $product['product_price'];

    // Check if product already exists in the cart
    $check_query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ii", $user_id, $product_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Update quantity if product is already in the cart
        $row = $check_result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;

        $update_query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
        $update_stmt->execute();
    } else {
        // Insert new product into cart
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $insert_stmt->execute();
    }

    $_SESSION['success'] = "Product added to cart successfully!";
    header("Location: cart.php"); // Redirect to the cart page
    exit();
} else {
    header("Location: products.php");
    exit();
}
?>
