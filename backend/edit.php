<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login_page.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: ../admin_panel.php');
    exit();
}

include('./connection.php');

$id = intval($_GET['id']); 

// Fetch product details
$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header('Location: ../admin_panel.php?message=Product_not_found');
    exit();
}

$pImg = $product['product_image']; 

if (isset($_POST['save'])) {
    $pName = mysqli_real_escape_string($conn, $_POST['productname']);
    $pBrand = mysqli_real_escape_string($conn, $_POST['brand']);
    $pPrice = floatval($_POST['productprice']);
    $pDiscount = floatval($_POST['productdiscount']);
    $pCode = mysqli_real_escape_string($conn, $_POST['productcode']);
    $pQuantity = intval($_POST['productquantity']);
    $pDesc = mysqli_real_escape_string($conn, $_POST['description']);
    $pFragranceType = mysqli_real_escape_string($conn, $_POST['fragrance_type']);
    $pVolume = intval($_POST['volume_ml']);

    // Image Upload Handling
    if (!empty($_FILES['img']['name'])) {
        $img = $_FILES['img'];
        $imgName = $img['name'];
        $imgTempLoc = $img['tmp_name'];
        $imgSize = $img['size'];
        $imgError = $img['error'];

        $imgType = explode('.', $imgName);
        $imgExt = strtolower(end($imgType));
        $allowed = ['png', 'jpg', 'jpeg'];

        if (in_array($imgExt, $allowed)) {
            if ($imgError === 0) {
                // Delete old image if exists
                $oldImagePath = "../product_imgs/" . $pImg;
                if (file_exists($oldImagePath) && $pImg !== "") {
                    unlink($oldImagePath);
                }

                // Save new image
                $pImg = uniqid("img_") . '.' . $imgExt;
                $imgDestination = "../product_imgs/" . $pImg;
                move_uploaded_file($imgTempLoc, $imgDestination);
            } else {
                header('Location: ../update_product.php?id=' . $id . '&img=error');
                exit();
            }
        } else {
            header('Location: ../update_product.php?id=' . $id . '&img=wrong_file_input');
            exit();
        }
    }

    // Update Query
    $updateQuery = "UPDATE products SET 
        product_name = ?, 
        brand = ?, 
        product_price = ?, 
        product_code = ?, 
        product_discount = ?, 
        product_quantity = ?, 
        fragrance_type = ?, 
        volume_ml = ?, 
        product_image = ?, 
        product_detail = ? 
        WHERE product_id = ?";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssdsiissssi", 
        $pName, $pBrand, $pPrice, $pCode, 
        $pDiscount, $pQuantity, $pFragranceType, 
        $pVolume, $pImg, $pDesc, $id
    );

    if ($stmt->execute()) {
        header('Location: ../admin_panel.php?message=Updated_successfully');
        exit();
    } else {
        echo "Error! Data Update Failed: " . $conn->error;
    }
}
?>
