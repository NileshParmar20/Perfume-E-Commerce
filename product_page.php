<?php
include('./backend/connection.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ./products.php');
    exit();
}

$id = intval($_GET['id']); // Prevent SQL injection
$query = "SELECT * FROM products WHERE product_id = $id";
$result = $conn->query($query);

if (!$result || $result->num_rows == 0) {
    header('Location: ./products.php'); // Redirect if no product found
    exit();
}

$product = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfume Shop | <?php echo htmlspecialchars($product['product_name']); ?></title>

    <!-- Tab Icon -->
    <link rel="icon" href="./images/perfume.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./styles/product_page.css">
</head>
<body>
    <?php include('./header.php'); ?>
    
    <main>
        <section id="product" class="container">
            <div class="content p-grid">
                <h1 class="p-name color-primary"><?php echo htmlspecialchars($product['product_name']); ?></h1>
                
                <div class="p-image">
                    <img src="./product_imgs/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image">
                </div>
                
                <div class="p-info">
                    <ul>
                        <li><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand']); ?></li>
                        <li><strong>Fragrance Type:</strong> <?php echo htmlspecialchars($product['fragrance_type']); ?></li>
                        <li><strong>Volume:</strong> <?php echo $product['volume_ml']; ?> ml</li>
                        <li><strong>Product Code:</strong> <?php echo htmlspecialchars($product['product_code']); ?></li>
                        <li><strong>Stock Available:</strong> <?php echo $product['product_quantity']; ?></li>
                        <li><strong>Discount:</strong> <?php echo $product['product_discount']; ?>%</li>
                    </ul>

                    <h4 class="product-price">
                        <?php if ($product['product_discount'] > 0) { ?>
                            <span class="text-danger">
                                <del><?php echo number_format($product['product_price'], 2); ?>₹</del>
                            </span>
                            <span class="text-success">
                                <?php 
                                    $discounted_price = $product['product_price'] - ($product['product_price'] * ($product['product_discount'] / 100));
                                    echo number_format($discounted_price, 2); 
                                ?>₹
                            </span>
                        <?php } else { ?>
                            <span><?php echo number_format($product['product_price'], 2); ?>₹</span>
                        <?php } ?>
                    </h4>
                    
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $product['product_price']; ?>">
                        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['product_quantity']; ?>" class="form-control mb-2">
                        <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
                    </form>
                </div>
                
                <div class="p-detail">
                    <h2 class="color-primary">Product Description</h2>
                    <p><?php echo nl2br(htmlspecialchars($product['product_detail'])); ?></p>
                </div>
            </div>
        </section>
    </main>

    <?php include('./footer.php'); ?>
</body>
</html>
