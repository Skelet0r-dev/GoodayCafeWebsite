<?php
$serverName = "ANGELO\\SQLEXPRESS";
$connectionOptions = [
    "Database" => "Good_Day_Cafe",
    "Uid" => "", 
    "PWD" => "",
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Get POST data
$product_name = $_POST['productName'] ;
$product_price = $_POST['productPrice'];
$product_description = $_POST['productDescription'];
$product_category = $_POST['productCategory'];
$image = $_FILES['productImage'];

// Validate POST data
if (!$product_name || !$product_price || !$product_description || !$product_category || !$image) {
    die("All fields are required.");
}

// Insert product into the database
$insertProductQuery = "
    INSERT INTO PRODUCTS (PRODUCT_NAME, PRICE, DESCRIPTION, PRODUCT_CATEGORY)
    VALUES ('$product_name', '$product_price', '$product_description', '$product_category')
";

$resultProduct = sqlsrv_query($conn, $insertProductQuery);

if ($resultProduct === false) {
    error_log(print_r(sqlsrv_errors(), true));
    die("Failed to add product.");
}

// Retrieve the product ID
$getProductIdQuery = "SELECT PRODUCT_ID FROM PRODUCTS WHERE PRODUCT_NAME = '$product_name' AND PRICE = '$product_price'";

$resultId = sqlsrv_query($conn, $getProductIdQuery);

if ($resultId === false) {
    error_log(print_r(sqlsrv_errors(), true));
    die("Failed to retrieve product ID.");
}

$row = sqlsrv_fetch_array($resultId, SQLSRV_FETCH_ASSOC);
$productId = $row['PRODUCT_ID'];

if (!$productId) {
    die("Failed to retrieve a valid product ID.");
}

// Handle image upload
$destination = "C:\\xampp\\htdocs\\demo\\GoodayCafeWebsite-main\\uploads\\";
$imageName = basename($image['name']);
$targetImagePath = $destination . $imageName;
$allowedTypes = ['png', 'jpg', 'jpeg', 'gif'];
$fileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

// Validate image type
if (!in_array($fileType, $allowedTypes)) {
    die("Unsupported image format. Allowed formats: PNG, JPG, JPEG, GIF.");
}

// Move uploaded image
if (!move_uploaded_file($image['tmp_name'], $targetImagePath)) {
    die("Failed to upload image.");
}

// Insert image data into the database
$insertImageQuery = "
    INSERT INTO PRODUCT_IMAGE (IMAGE_NAME, FILEPATH, PRODUCT_ID)
    VALUES ('$imageName', '$targetImagePath', '$productId')
";
    
$resultImage = sqlsrv_query($conn, $insertImageQuery);

if ($resultImage === false) {
    error_log(print_r(sqlsrv_errors(), true));
    die("Failed to save image data.");
}

// Success message
echo "<script>
    alert('Product added successfully.');
    window.location.href = 'adminpage.php';
</script>";
?>