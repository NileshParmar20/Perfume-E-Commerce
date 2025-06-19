<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indian Watch Shop | Login</title>

    <!-- Tab Icon -->
    <link rel="icon" href="./images/watch.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Fonts Awesome -->
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./styles/login.css">
</head>
<body>
    <?php include('./header.php'); ?>
    

    <main>
        <div class="content f-box">
            <div class="login">
                <div class="pic">
                    <!-- <img class="responsive" src="./images/login-img.jpg" alt="Login Image"> -->
                </div>
                <div class="f-box">
                    <div class="form-wrap">
                        <h1 class="l-heading">
                            <span class="color-primary">Log</span>in
                        </h1>

                        <?php 
                        if (isset($_GET['login'])) {
                            if ($_GET['login'] == "failed") {
                                echo '<div class="alert alert-danger">Incorrect Username or Password!</div>';
                            } elseif ($_GET['login'] == "empty") {
                                echo '<div class="alert alert-warning">Please fill in all fields!</div>';
                            }
                        }
                        ?>
                        
                        <form action="./backend/login.php" method="POST">
                            <div class="form-group">
                                <label for="username"><i class="fas fa-user"></i></label>
                                <input type="text" name="username" placeholder="Enter Username or Email" required>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="fas fa-key"></i></label>
                                <input type="password" name="password" placeholder="Enter Password" required>
                            </div>
                            <input class="bttn" type="submit" name="Login" value="Login">
                        </form>

                        <p>Don't have an account? <a href="user_register.php">Register Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include('./footer.php'); ?>
</body>
</html>
