<?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        header('Location: ./login_page.php');
        exit(); // Stop further execution
    }

    include('./backend/connection.php'); // Database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfume Shop | Add Product</title>

    <!-- Tab Icon -->
    <link rel="icon" href="./images/perfume.png"> <!-- Updated favicon -->

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Fonts Awesome -->
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="./styles/add_product.css">
</head>
<body>
    <div id="add-product">
        <div class="form-wrap">
            <h1 class="m-heading">
                <span class="color-primary">Add</span> Perfume
            </h1>

            <!-- Error Messages -->
            <?php if (isset($_GET['perc'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Error!</strong> Discount percentage must be 100 or lower.
                </div>
            <?php } elseif (isset($_GET['img'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Error!</strong> Failed to upload image. Ensure it is a valid format (JPG, PNG, etc.).
                </div>
            <?php } ?>

            <!-- Product Form -->
            <form action="./backend/add.php" method="POST" enctype="multipart/form-data">
                
                <!-- Product Name -->
                <div class="form-group">
                    <label for="productname">Perfume Name</label>
                    <input type="text" name="productname" class="form-control" placeholder="Enter Perfume Name" required>
                </div>

                <!-- Brand -->
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" name="brand" class="form-control" placeholder="Enter Brand Name" required>
                </div>

                <!-- Product Price -->
                <div class="form-group">
                    <label for="productprice">Price (₹)</label>
                    <input type="number" min="0" step="0.01" name="productprice" class="form-control" placeholder="Enter Price" required>
                </div>

                <!-- Product Code -->
                <div class="form-group">
                    <label for="productcode">Product Code</label>
                    <input type="text" name="productcode" class="form-control" placeholder="Enter Product Code" required>
                </div>

                <!-- Product Discount -->
                <div class="form-group">
                    <label for="productdiscount">Discount (%)</label>
                    <input type="number" min="0" max="100" step="0.01" name="productdiscount" class="form-control" placeholder="Enter Discount (if any)">
                </div>

                <!-- Fragrance Type -->
                <div class="form-group">
                    <label for="fragrance_type">Fragrance Type</label>
                    <select name="fragrance_type" class="form-control" required>
                        <option value="">Select Fragrance Type</option>
                        <option value="Floral">Floral</option>
                        <option value="Woody">Woody</option>
                        <option value="Citrus">Citrus</option>
                        <option value="Spicy">Spicy</option>
                        <option value="Fresh">Fresh</option>
                    </select>
                </div>

                <!-- Perfume Volume -->
                <div class="form-group">
                    <label for="volume_ml">Volume (ml)</label>
                    <input type="number" min="1" step="1" name="volume_ml" class="form-control" placeholder="Enter Volume in ml" required>
                </div>

                <!-- Product Quantity -->
                <div class="form-group">
                    <label for="productquantity">Stock Quantity</label>
                    <input type="number" min="1" step="1" name="productquantity" class="form-control" placeholder="Enter Available Stock" required>
                </div>

                <!-- Product Image -->
                <div class="form-group">
                    <label for="productimage">Product Image</label>
                    <input type="file" name="img" class="form-control-file" accept="image/*" required>
                </div>

                <!-- Product Description -->
                <div class="form-group">
                    <label for="description">Product Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Enter Perfume Description" required></textarea>
                </div>

                <!-- Buttons -->
                <button type="submit" class="btn btn-primary" name="save">Save</button>
                <a href="./admin_panel.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
