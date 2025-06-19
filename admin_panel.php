<?php
session_start();
include('./backend/connection.php');

if (!isset($_SESSION['admin'])) {
    header('Location: ./login_page.php');
    exit();
}

// Fetch products from the correct table
$query = "SELECT * FROM products";
$result = $conn->query($query);

if (!$result) {
    die("Database query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfume Shop | Admin Panel</title>
    <link rel="icon" href="./images/perfume.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/admin.css">
</head>
<body>
    <?php include('./header.php'); ?>

    <main>
        <div class="admin-panel">
            <div class="admin-welcome">
                <h2><i class="fas fa-user-circle"></i> Welcome @<?php echo $_SESSION["admin"]; ?></h2>
            </div>
            <div class="admin-actions">
                <a class="btn btn-primary btn-lg" href="./add_product.php">Add New Product</a> 
            </div>
            <br>
            <div class="products-table">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Fragrance Type</th>
                            <th>Volume (ml)</th>
                            <th>Price</th>
                            <th>Discount (%)</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($data = mysqli_fetch_array($result)) { ?>
                            <tr>
                                <td><?php echo $data['product_id']; ?></td>
                                <td><?php echo htmlspecialchars($data['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($data['brand']); ?></td>
                                <td><?php echo htmlspecialchars($data['fragrance_type']); ?></td>
                                <td><?php echo $data['volume_ml']; ?> ml</td>
                                <td>₹<?php echo number_format($data['product_price'], 2); ?></td>
                                <td><?php echo $data['product_discount'] ?: 'N/A'; ?>%</td>
                                <td><?php echo $data['product_quantity']; ?></td>
                                <td>
                                    <img class="p-img" src="./product_imgs/<?php echo htmlspecialchars($data['product_image']); ?>" alt="Product Image" width="70">
                                </td>
                                <td>
                                    <a class="btn btn-edit" href="./update.php?id=<?php echo $data['product_id']; ?>">
                                        <span class="fas fa-edit"></span>
                                    </a>
                                    <form action="./backend/delete.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $data['product_id']; ?>">
                                        <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this product?');">
                                            <span class="fas fa-trash-alt"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include('./footer.php'); ?>
</body>
</html>