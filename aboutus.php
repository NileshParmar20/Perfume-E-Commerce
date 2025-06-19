<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfume Store | About Us</title>

    <!-- Tab Icon -->
    <link rel="icon" href="./images/perfume-icon.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="./styles/aboutus.css">
</head>
<body>
    <?php include('./header.php'); ?>
    
    <main>
        <section id="aboutus" class="container">
            <div class="content aboutus-grid">
                <div class="about-text">
                    <h1><span class="color-primary">About</span> Us</h1>
                    <p>
                        Welcome to our exclusive **perfume store**, where fragrance meets elegance. We offer a **wide range of luxurious, long-lasting, and high-quality perfumes** from **top international brands**. Whether you're looking for a **fresh daily scent** or a **luxurious fragrance for special occasions**, we have something for everyone.
                        <br><br>
                        We believe in providing **authentic and original perfumes** that leave a lasting impression. Our collection includes **eau de parfum, eau de toilette, and perfume oils** that cater to different preferences.
                    </p>
                </div>
                <div class="about-img1"></div>
            </div>

            <div class="content aboutus-grid">
                <div class="about-img2"></div>
                <div class="about-text">
                    <h1><span class="color-primary">Why</span> Buy From Us</h1>
                    <p>
                        Our **perfumes are 100% original and sourced from top international brands**. We guarantee:
                        <ul>
                            <li>**Long-lasting and premium-quality fragrances**</li>
                            <li>**Exclusive discounts and special offers**</li>
                            <li>**Fast and secure delivery across the country**</li>
                            <li>**Easy returns and customer satisfaction guarantee**</li>
                        </ul>
                        We ensure that every bottle we sell is **authentic, fresh, and properly stored** to maintain its **true essence**.
                    </p>
                </div>
            </div>
        </section>

        <section id="reviews" class="container">
            <div class="content">
                <h1><span class="color-primary">Reviews</span> From Our Customers</h1>
                <div>
                    <div class="review-card">
                        <div class="review-user">
                            <i class="fas fa-user fa-2x"></i>
                            <i class="fab fa-twitter fa-2x"></i>
                        </div>
                        <div class="review">
                            <h5>@Ayesha_Khan</h5>
                            <p>"Absolutely love the fragrances! The quality is outstanding, and the scent lasts all day. Highly recommended!"</p>
                        </div>
                    </div>
                    
                    <div class="review-card">
                        <div class="review-user">
                            <i class="fas fa-user fa-2x"></i>
                            <i class="fab fa-twitter fa-2x"></i>
                        </div>
                        <div class="review">
                            <h5>@Rohan_Verma</h5>
                            <p>"One of the best perfume stores I’ve shopped from. They have a wide range of collections and amazing deals!"</p>
                        </div>
                    </div>
                    
                    <div class="review-card">
                        <div class="review-user">
                            <i class="fas fa-user fa-2x"></i>
                            <i class="fab fa-twitter fa-2x"></i>
                        </div>
                        <div class="review">
                            <h5>@Simran_Mehta</h5>
                            <p>"Fast delivery, excellent packaging, and top-notch perfumes. This store never disappoints!"</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('./footer.php'); ?>
</body>
</html>
