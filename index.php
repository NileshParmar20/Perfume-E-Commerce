<?php
    include('./backend/connection.php');

    $query = "SELECT * FROM products ORDER BY product_id DESC;";
    $result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aroma | Home</title>

    <!-- Tab Icon -->
    <link rel="icon" href="./images/perfume-icon.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <?php include('./header.php') ?>

    <main>
      <!-- Hero Slider -->
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="./images/perfume-banner1.jpg" alt="Premium Fragrances" width="100%" height="525px">
          </div>
          <div class="carousel-item">
            <img src="./images/perfume-banner2.jpg" alt="Luxury Perfumes" width="100%" height="525px">
          </div>
          <div class="carousel-item">
            <img src="./images/perfume-banner3.jpg" alt="Exclusive Scents" width="100%" height="525px">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon"></span>
        </a>
      </div>

      <!-- About Section -->
      <section id="about" class="container">
        <div class="content">
          <div>
            <h1><span class="color-primary">About</span> Us</h1>
            <p>Welcome to **Aroma**, your go-to destination for the most exquisite and luxurious fragrances. From classic scents to modern blends, we have the perfect perfume for every personality. Elevate your presence with a signature scent that defines you.</p>
            <a href="./aboutus.php" class="bttn">Learn More</a>
          </div>
          <div class="scent-img" ></div>
        </div>
      </section>

      <!-- Featured Products Section -->
      <section id="featured" class="container">
        <div class="content">
          <h1 class="featured-heading">
            <span class="color-primary">Featured</span> Perfumes
          </h1>
          <div class="product-grid">
            <?php
                for($i = 0; $i < 4; $i++)
                {
                    $data = mysqli_fetch_array($result);
                    if($data['product_quantity'] == 0)
                    {
                        continue;
                    }
                    ?>
                    <a class="product" href="./product_page.php?id=<?php echo $data['product_id']; ?>">
                        <img src="./product_imgs/<?php echo $data['product_image']; ?>" alt="Perfume Image" height="200px">
                        <div class="product-info">
                            <h5><?php echo $data['product_name']; ?></h5>
                            <h6><?php echo $data['product_price']; ?>₹</h6>
                        </div>
                    </a>
              <?php
                }
              ?>
          </div>
        </div>
      </section>
    </main>

    <?php include('./footer.php') ?>
</body>
</html>
