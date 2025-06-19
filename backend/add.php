<?php
if(isset($_POST['save'])) {
    // Getting data from form
    $pName = $_POST['productname'];
    $brand = $_POST['brand'];  // Added brand input
    $pPrice = $_POST['productprice'];
    $pDiscount = $_POST['productdiscount'];
    $pCode = $_POST['productcode'];
    $pQuantity = $_POST['productquantity'];
    $pVolume = $_POST['volume_ml'];  // Added volume (ml)
    $pFragrance = $_POST['fragrance_type'];  // Added fragrance type
    $pDesc = $_POST['description'];

    // Product Image Upload
    $img = $_FILES['img'];
    $imgName = $img['name'];
    $imgTempLoc = $img['tmp_name'];
    $imgSize = $img['size'];
    $imgError = $img['error'];

    $imgType = explode('.', $imgName);
    $imgExt = strtolower(end($imgType));

    $allowed = array('png', 'jpg', 'jpeg');

    if (in_array($imgExt, $allowed)) {
        if ($imgError === 0) {
            $imgNewName = uniqid("perfume_") . '.' . $imgExt;
            $imgDestination = '../product_imgs/' . $imgNewName;

            // Ensure folder exists
            if (!file_exists('../product_imgs')) {
                mkdir('../product_imgs', 0777, true);
            }

            move_uploaded_file($imgTempLoc, $imgDestination);
        } else {
            header('Location: ../add_product.php?img=error');
            exit();
        }
    } else {
        header('Location: ../add_product.php?img=wrong_file_input');
        exit();
    }

    // Saving data in database using Prepared Statements
    include('./connection.php');

    $query = "INSERT INTO products (product_name, brand, product_price, product_code, product_in_stock, product_discount, volume_ml, fragrance_type, product_detail, product_image, product_quantity) 
              VALUES (?, ?, ?, ?, 1, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssdsdisssi", $pName, $brand, $pPrice, $pCode, $pDiscount, $pVolume, $pFragrance, $pDesc, $imgNewName, $pQuantity);

    if ($stmt->execute()) {
        // Record added successfully
        header('Location: ../admin_panel.php?message=Added_successfully');
    } else {
        echo "Error! Data Insertion Failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
