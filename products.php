<?php
session_start();
include('./backend/connection.php');

$query = "SELECT * FROM products WHERE product_quantity > 0;";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfume Shop | Products</title>

    <!-- Tab Icon -->
    <link rel="icon" href="./images/perfume.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./styles/common.css">
</head>
<body>
    <?php include('./header.php'); ?>
  
    <main>
      <section id="featured" class="container">
        <div class="content">
          <h1 class="featured-heading">
            <span class="color-primary">Our</span> Perfumes
          </h1>
          <div class="product-grid">
            <?php while ($data = mysqli_fetch_array($result)) { ?>
              <div class="product">
                  <a href="./product_page.php?id=<?php echo $data['product_id']; ?>">
                      <img src="./product_imgs/<?php echo htmlspecialchars($data['product_image']); ?>" alt="Product Image" height="200px">
                  </a>
                  <div class="product-info">
                      <h5><?php echo htmlspecialchars($data['product_name']); ?></h5>
                      <p class="text-muted"><?php echo htmlspecialchars($data['brand']); ?> | <?php echo htmlspecialchars($data['fragrance_type']); ?></p>
                      <p><strong><?php echo $data['volume_ml']; ?> ml</strong></p>
                      <h6>
                        <?php if ($data['product_discount'] > 0) { ?>
                          <span class="text-danger">
                              <del><?php echo number_format($data['product_price'], 2); ?>₹</del>
                          </span>
                          <span class="text-success">
                              <?php 
                                  $discounted_price = $data['product_price'] - ($data['product_price'] * ($data['product_discount'] / 100));
                                  echo number_format($discounted_price, 2); 
                              ?>₹
                          </span>
                        <?php } else { ?>
                          <span><?php echo number_format($data['product_price'], 2); ?>₹</span>
                        <?php } ?>
                      </h6>
                  </div>
                  <form action="add_to_cart.php" method="POST">
                      <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">
                      <input type="hidden" name="product_price" value="<?php echo $data['product_price']; ?>">
                      <!-- <input type="number" name="quantity" value="1" min="1" max="<?php echo $data['product_quantity']; ?>" class="form-control mb-2">
                      <button type="submit" class="btn btn-primary btn-block">Add to Cart</button> -->
                  </form>
              </div>
            <?php } ?>
          </div>
        </div>
      </section>
    </main>
    <?php include('./footer.php'); ?>
</body>
</html>
