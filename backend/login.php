<?php
session_start();
include("./connection.php");

if (isset($_POST["Login"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        header("Location: ../login_page.php?login=empty");
        exit();
    }

    // Check if the user is an admin
    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_name = ? AND admin_password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $adminResult = $stmt->get_result();

    if ($adminResult->num_rows > 0) {
        $adminRow = $adminResult->fetch_assoc();
        session_regenerate_id(true);
        $_SESSION['admin'] = $adminRow['admin_name'];
        header("Location: ../admin_panel.php");
        exit();
    }

    // Check if the credentials match a user
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR name = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $userResult = $stmt->get_result();

    if ($userResult->num_rows > 0) {
        $userRow = $userResult->fetch_assoc();
        
        if (password_verify($password, $userRow['password'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = $userRow['name'];
            $_SESSION['user_id'] = $userRow['id'];
            header("Location: ../index.php");
            exit();
        }
    }

    // If login fails
    header("Location: ../login_page.php?login=failed");
    exit();
}
?>
