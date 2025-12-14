<?php
$serverName = "ANGELO\\SQLEXPRESS";
$connectionOptions = [
    "Database" => "Good_Day_Cafe",
    "Uid" => "",
    "PWD" => "",
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    error_log(print_r(sqlsrv_errors(), true));
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

// Get the product ID from POST
$productId = intval($_POST['product_id'] ?? 0);

if ($productId <= 0) {
    die(json_encode(['success' => false, 'message' => 'Invalid product ID.']));
}

// Get the image path
$getImageQuery = "SELECT FILEPATH FROM PRODUCT_IMAGE WHERE PRODUCT_ID = ?";
$params = [$productId];
$result = sqlsrv_query($conn, $getImageQuery, $params);

if ($result === false) {
    error_log(print_r(sqlsrv_errors(), true));
    die(json_encode(['success' => false, 'message' => 'Failed to retrieve image path.']));
}

$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
$imagePath = $row['FILEPATH'] ?? null;

// Delete image record from database
$deleteImageQuery = "DELETE FROM PRODUCT_IMAGE WHERE PRODUCT_ID = ?";
sqlsrv_query($conn, $deleteImageQuery, [$productId]);

// Delete product record
$deleteProductQuery = "DELETE FROM PRODUCTS WHERE PRODUCT_ID = ?";
if (sqlsrv_query($conn, $deleteProductQuery, [$productId]) === false) {
    error_log(print_r(sqlsrv_errors(), true));
    die(json_encode(['success' => false, 'message' => 'Failed to delete product.']));
}

// Delete the actual image file from the directory
if ($imagePath && file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $imagePath)) {
    unlink($_SERVER['DOCUMENT_ROOT'] . "/" . $imagePath);
}

// Return success response
echo json_encode(['success' => true]);
?>