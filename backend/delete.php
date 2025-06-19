<?php
session_start();
include('../backend/connection.php');

if (!isset($_SESSION['admin'])) {
    header("Location: ../login_page.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $product_id = $_POST['id'];

    // Fetch product image filename from the database
    $query = "SELECT product_image FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->bind_result($product_image);
        $stmt->fetch();
        $stmt->close();

        // Delete product from database
        $deleteQuery = "DELETE FROM products WHERE product_id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);

        if ($deleteStmt) {
            $deleteStmt->bind_param("i", $product_id);
            if ($deleteStmt->execute()) {
                // Remove image from the server if it exists
                $image_path = "../product_imgs/" . $product_image;
                if (!empty($product_image) && file_exists($image_path)) {
                    unlink($image_path);
                }

                $_SESSION['success'] = "Product deleted successfully!";
            } else {
                $_SESSION['error'] = "Failed to delete product: " . $deleteStmt->error;
            }
            $deleteStmt->close();
        } else {
            $_SESSION['error'] = "Query preparation failed: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "Error fetching product image: " . $conn->error;
    }

    $conn->close();
} else {
    $_SESSION['error'] = "Invalid request! Missing product ID.";
}

header("Location: ../admin_panel.php");
exit();
?>
