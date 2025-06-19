<?php
include 'backend/connection.php'; // Database connection
include './header.php'; // Include header

$search_query = "";

// Check if 'query' is set
if (isset($_GET['query'])) {
    $search_query = trim($_GET['query']); // Store search query

    if (!empty($search_query)) {
        $search = "%" . $search_query . "%"; // Add wildcard for LIKE search

        // ✅ Search in 'product_name', 'brand', and 'product_code'
        $sql = "SELECT * FROM products WHERE product_name LIKE ? OR product_code LIKE ? OR brand LIKE ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error in SQL query: " . $conn->error); // Debugging message
        }

        $stmt->bind_param("sss", $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="./styles/search.css">
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
    <h2>Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h2>

    <div class="product-grid">
        <?php
        if (isset($result) && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <a href="product_page.php?id=<?php echo $row['product_id']; ?>" class="product-link">
                    <div class="product">
                        <img src="product_imgs/<?php echo htmlspecialchars($row['product_image']); ?>" 
                             alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                        <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                        <p>Brand: <strong><?php echo htmlspecialchars($row['brand']); ?></strong></p>
                        <p>Product Code: <strong><?php echo htmlspecialchars($row['product_code']); ?></strong></p>
                        <p>Price: <strong>₹<?php echo number_format($row['product_price'], 2); ?></strong></p>
                        
                        <?php if ($row['product_in_stock'] > 0): ?>
                            <p>Stock: <strong><?php echo $row['product_in_stock']; ?> available</strong></p>
                        <?php else: ?>
                            <p style="color: red;"><strong>Out of Stock</strong></p>
                        <?php endif; ?>
                    </div>
                </a>
                <?php
            }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>
</div>

<?php include './footer.php'; ?>

</body>
</html>
