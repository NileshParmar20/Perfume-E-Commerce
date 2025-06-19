<?php
include './header.php';
include 'backend/connection.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO contact (name, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Error preparing SQL statement: " . $conn->error); // Debugging Line
        }

        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            echo "<script>alert('Message sent successfully!'); window.location.href='contactus.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error sending message: " . $stmt->error . "');</script>"; // Debugging Line
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfume Store | Contact Us</title>

    <!-- Tab Icon -->
    <link rel="icon" href="./images/perfume-icon.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <!-- Leaflet CSS (For Free OpenStreetMap) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Custom Styles -->
    <link rel="stylesheet" href="./styles/contactus.css">
</head>
<body>

<main>
  <section id="contact" class="container">
    <div class="content contact-info">
      <div class="box">
        <i class="fas fa-store fa-3x"></i>
        <h2>Our Store</h2>
        <p>Kadi, Gujarat, India</p>
      </div>
      <div class="box">
        <i class="fas fa-phone fa-3x"></i>
        <h2>Customer Support</h2>
        <p>+91 9876543210</p>
      </div>
      <div class="box">
        <i class="fas fa-envelope fa-3x"></i>
        <h2>Email Us</h2>
        <p>support@perfumeheaven.com</p>
      </div>
    </div>

    <div class="content form-n-map">
      <div class="contact-form">
        <h1 class="m-heading"><span class="color-primary">Get in</span> Touch</h1>
        <form action="contactus.php" method="POST">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="example@email.com" required>
            </div>
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea name="message" id="message" placeholder="Enter your message" required></textarea>
            </div>
            <input class="bttn" type="submit" value="Send">
        </form>
      </div>
      
      <!-- Map Section -->
      <div id="map" style="height: 400px; border-radius: 10px;"></div>
    </div>
  </section>
</main>

<?php include './footer.php'; ?>

<!-- Leaflet JS (For Free OpenStreetMap) -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    function initMap() {
        var location = [23.2990, 72.3340]; // Kadi, Gujarat Coordinates
        var map = L.map('map').setView(location, 12);

        // Add OpenStreetMap Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Add Marker
        L.marker(location).addTo(map)
            .bindPopup("<b>Kadi, Gujarat</b><br>Perfume Store Location")
            .openPopup();
    }

    document.addEventListener("DOMContentLoaded", initMap);
</script>

</body>
</html>
