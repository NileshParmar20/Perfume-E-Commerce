<?php
include("./backend/connection.php");

if (isset($_POST["register"])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert into database
    $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $name, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location='login_page.php';</script>";
    } else {
        echo "<script>alert('Error registering user!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indian Watch Shop | Register</title>

    <!-- Tab Icon -->
    <link rel="icon" href="./images/watch.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./styles/register.css">
</head>
<body>
    <?php include('./header.php'); ?>
    

    <main>
        <div class="content f-box">
            <div class="register">
                <div class="pic">
                <!-- <img class="responsive" src="./images/register-img.jpg" alt="Login Image"> -->
                </div>
                <div class="f-box">
                    <div class="form-wrap">
                        <h1 class="l-heading">
                            <span class="color-primary">Sign</span> Up
                        </h1>

                        <form method="POST">
                            <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i></label>
                                <input type="text" name="name" placeholder="Full Name" required>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i></label>
                                <input type="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="fas fa-key"></i></label>
                                <input type="password" name="password" placeholder="Password" required>
                            </div>
                            <input class="bttn" type="submit" name="register" value="Register">
                        </form>

                        <p>Already have an account? <a href="login_page.php">Login Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include('./footer.php'); ?>
</body>
</html>
