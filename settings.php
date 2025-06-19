<?php
session_start();
include('./backend/connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php?error=login_required");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Fetch user details
$query = "SELECT name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = trim($_POST['name']);
    $new_email = trim($_POST['email']);
    $new_password = trim($_POST['password']);

    // Update query
    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $updateQuery = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssi", $new_name, $new_email, $hashed_password, $user_id);
    } else {
        $updateQuery = "UPDATE users SET name = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssi", $new_name, $new_email, $user_id);
    }

    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="./styles/userboard_settings.css">
    <script src="https://kit.fontawesome.com/8408dd06d8.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include('header.php'); ?>

    <div class="settings-container">
        <div class="settings-header">
            <h2>Account Settings</h2>
        </div>

        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="POST" class="settings-form">
            <div class="input-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="input-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="input-group">
                <label for="password">New Password (Optional)</label>
                <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
            </div>

            <button type="submit" class="btn-primary">Update Profile</button>
        </form>
    </div>
</body>
</html>
<?php include('footer.php'); ?> 