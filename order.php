<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId     = $_POST['userIdInput'];
    $cartData   = $_POST['cartItemsInput'];
    $totalPrice = $_POST['totalPriceInput'];

    echo "<h2>User ID: " . ($userId) . "</h2><br>";

    if ($cartData && $totalPrice) {
        $cartItems = json_decode($cartData, true);

        echo "<h1>Order Summary</h1>";
        foreach ($cartItems as $item) {
            echo 'Product ID: ' . htmlspecialchars($item['id']) . "<br>";
            echo "Product: " . htmlspecialchars($item['name']) . "<br>";
            echo "Price: ₱" . htmlspecialchars($item['price']) . "<br>";
            echo "Quantity: " . htmlspecialchars($item['quantity']) . "<br><br>";
        }
    }

    echo "<strong>Total Price:</strong> ₱" . intval($totalPrice) . "<br>";
    $totalPrice = intval($totalPrice);

    $serverName = "ANGELO\\SQLEXPRESS";
    $connectionOptions = [
        "Database" => "Good_Day_Cafe",
        "Uid" => "",
        "PWD" => ""
    ];

    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Connected to the database successfully.<br>";
    }

    // Insert a single ORDER row (outside the item loop)
    $sqlOrderInsert = "INSERT INTO dbo.[ORDER] ([USER_ID], [TOTAL_PRICE], [ORDER_PLACED], [DISCOUNT]) 
                       VALUES (?, ?, ?, ?)";
    $paramsOrder = [
        $userId,
        $totalPrice,
        date('Y-m-d H:i:s'),
        0
    ];
    $stmtOrderHeader = sqlsrv_query($conn, $sqlOrderInsert, $paramsOrder);
    if ($stmtOrderHeader === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Get last inserted ORDER_ID (using IDENT_CURRENT as in your original)
    $sqlGetOrderId = "SELECT ORDER_ID
                      FROM dbo.[ORDER]
                      WHERE ORDER_ID = IDENT_CURRENT('dbo.[ORDER]');";
    $stmtGetOrderId = sqlsrv_query($conn, $sqlGetOrderId);
    if ($stmtGetOrderId === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        $row = sqlsrv_fetch_array($stmtGetOrderId, SQLSRV_FETCH_ASSOC);
        $orderId = $row['ORDER_ID'];
    }

    // Insert ORDER_ITEM rows (inside the loop)
    $sqlItemInsert = "INSERT INTO dbo.[ORDER_ITEM] ([ORDER_ID], [PRODUCT_ID], [PRODUCT_NAME], [QUANTITY], [PRICE]) 
                      VALUES (?, ?, ?, ?, ?)";
    foreach ($cartItems as $item) {
        $paramsItem = [
            $orderId,
            $item['id'],
            $item['name'],
            $item['quantity'],
            $item['price']
        ];
        $stmtItem = sqlsrv_query($conn, $sqlItemInsert, $paramsItem);
        if ($stmtItem === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    echo "<h3>Order has been placed successfully!</h3>";
}
?>