<?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        header('Location: ./login_page.php');
        exit();
    }

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header('Location: ./admin_panel.php?error=invalid_id');
        exit();
    }

    include('./backend/connection.php');

    // Fetch product details securely
    $id = intval($_GET['id']);
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        header('Location: ./admin_panel.php?error=product_not_found');
        exit();
    }

    $product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfume Shop | Edit Product</title>

    <!-- Tab Icon -->
    <link rel="icon" href="./images/perfume.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="./styles/update.css">
</head>
<body>
<div id="update-product" class="d-flex align-items-center justify-content-center">
        <div class="form-wrap">
            <h1 class="m-heading">
                <span class="color-primary">Edit</span> Perfume
            </h1>

            <!-- Error Messages -->
            <?php if (isset($_GET['perc'])) { ?>
                <div class="alert alert-danger">Error! Discount percentage must be 100 or lower.</div>
            <?php } elseif (isset($_GET['img'])) { ?>
                <div class="alert alert-danger">Error! Failed to upload image.</div>
            <?php } ?>

            <form action="./backend/edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                
                <!-- Product Name -->
                <div class="form-group">
                    <label for="productname">Perfume Name</label>
                    <input type="text" name="productname" class="form-control" 
                        value="<?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <!-- Brand -->
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" name="brand" class="form-control" 
                        value="<?php echo htmlspecialchars($product['brand'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <!-- Product Price -->
                <div class="form-group">
                    <label for="productprice">Price (₹)</label>
                    <input type="number" min="0" step="0.01" name="productprice" class="form-control" 
                        value="<?php echo htmlspecialchars($product['product_price'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <!-- Product Code -->
                <div class="form-group">
                    <label for="productcode">Product Code</label>
                    <input type="text" name="productcode" class="form-control" 
                        value="<?php echo htmlspecialchars($product['product_code'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <!-- Product Discount -->
                <div class="form-group">
                    <label for="productdiscount">Discount (%)</label>
                    <input type="number" min="0" max="100" step="0.01" name="productdiscount" class="form-control" 
                        value="<?php echo htmlspecialchars($product['product_discount'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <!-- Fragrance Type -->
                <div class="form-group">
                    <label for="fragrance_type">Fragrance Type</label>
                    <select name="fragrance_type" class="form-control" required>
                        <option value="">Select Fragrance Type</option>
                        <option value="Floral" <?php echo ($product['fragrance_type'] == "Floral") ? "selected" : ""; ?>>Floral</option>
                        <option value="Woody" <?php echo ($product['fragrance_type'] == "Woody") ? "selected" : ""; ?>>Woody</option>
                        <option value="Citrus" <?php echo ($product['fragrance_type'] == "Citrus") ? "selected" : ""; ?>>Citrus</option>
                        <option value="Spicy" <?php echo ($product['fragrance_type'] == "Spicy") ? "selected" : ""; ?>>Spicy</option>
                        <option value="Fresh" <?php echo ($product['fragrance_type'] == "Fresh") ? "selected" : ""; ?>>Fresh</option>
                    </select>
                </div>

                <!-- Perfume Volume -->
                <div class="form-group">
                    <label for="volume_ml">Volume (ml)</label>
                    <input type="number" min="1" step="1" name="volume_ml" class="form-control" 
                        value="<?php echo htmlspecialchars($product['volume_ml'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <!-- Product Quantity -->
                <div class="form-group">
                    <label for="productquantity">Stock Quantity</label>
                    <input type="number" min="1" step="1" name="productquantity" class="form-control" 
                        value="<?php echo htmlspecialchars($product['product_quantity'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <!-- Product Image -->
                <div class="form-group">
                    <label for="productimage">Product Image</label>
                    <input type="file" name="img" class="form-control-file" accept="image/*">
                    <p>Current Image:</p>
                    <img src="./product_imgs/<?php echo htmlspecialchars($product['product_image'], ENT_QUOTES, 'UTF-8'); ?>" 
                        alt="Product Image" width="150">
                </div>

                <!-- Product Description -->
                <div class="form-group">
                    <label for="description">Product Description</label>
                    <textarea name="description" class="form-control" rows="4" required><?php 
                        echo htmlspecialchars($product['product_detail'], ENT_QUOTES, 'UTF-8'); 
                    ?></textarea>
                </div>

                <!-- Buttons -->
                <button type="submit" class="btn btn-primary" name="save">Save</button>
                <a href="./admin_panel.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
