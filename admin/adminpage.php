<?php
session_start();
$serverName = "ANGELO\\SQLEXPRESS";
$connectionOptions = [
    "Database" => "Good_Day_Cafe",
    "Uid" => "",
    "PWD" => "",
];

// Secure database connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    error_log(print_r(sqlsrv_errors(), true));
    die("Database connection failed. Please try again later.");
}


$firstName = isset($_SESSION['fname']) ? $_SESSION['fname'] : 'Admin';
$lastName = isset($_SESSION['lname']) ? $_SESSION['lname'] : '';


// Fetch products with their images
$query = "
SELECT 
    p.PRODUCT_ID,
    p.PRODUCT_NAME,
    p.DESCRIPTION,
    p.PRICE,
    p.PRODUCT_CATEGORY,
    i.IMAGE_NAME,
    i.FILEPATH
FROM PRODUCTS p
LEFT JOIN PRODUCT_IMAGE i ON p.PRODUCT_ID = i.PRODUCT_ID
";

$result = sqlsrv_query($conn, $query);

if ($result === false) {
    error_log(print_r(sqlsrv_errors(), true)); // Log error if the query fails
    die("Failed to retrieve products. Please check your database logs.");
}

$products = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if (isset($row['FILEPATH'])) {
        $row['FILEPATH'] = str_replace(
            'C:\\xampp\\htdocs\\demo\\GoodayCafeWebsite-main', 
            '/demo/GoodayCafeWebsite-main', 
            $row['FILEPATH']
        );
    }
    $products[] = $row;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/demo/GoodayCafeWebsite-main/admin/adminpage.css">
</head>
<body class="d-flex flex-column align-items-center">

<h1 class="mt-4">Admin Page</h1>
<h4>Welcome, <?php echo htmlspecialchars($firstName . ' ' . $lastName); ?>!</h4>

<div class="container mt-4">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#addproduct">Products</a>
        </li>
    </ul>

    <div class="tab-content border border-top-0 p-3">


        <!-- Products Tab -->
        <div class="tab-pane fade show active" id="addproduct">
            <h4>Products</h4>
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#add-product-modal">
                Add Product
            </button>

<!-- NAVBAR -->   

<div class="container-fluid py-2 mb-2 sticky-top" style="z-index: 1050;">
  <div class="container py-3 px-3"
       style="background: rgb(92, 78, 59); border-radius:40px;">

    <div class="d-flex justify-content-center gap-2 align-items-center flex-wrap">

      <!-- Search -->
      <form class="d-flex" role="search" aria-label="Site search">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-sm rounded-pill"
                 type="search"
                 placeholder="Search"
                 aria-label="Search"
                 style="background:white; border:1px solid rgb(252, 215, 126); color:rgb(92, 78, 59);" />

          <button class="btn btn-sm rounded-pill ms-1 search-btn"
                  type="submit"
                  aria-label="Submit search">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>

      <div class="d-flex gap-2"> <!-- Nav Buttons -->
        <!-- Nav buttons with "active" glow toggle -->

        <a href="#productIcedDrinkRow"
           class="btn btn-sm rounded-pill nav-btn px-3 nav-link toggle-nav">
           Iced-Drinks
        </a>

        <a href="#productHotDrinkRow"
           class="btn btn-sm rounded-pill nav-btn px-3 nav-link toggle-nav">
           Hot-Drinks
        </a>

        <a href="#productRefresherRow"
           class="btn btn-sm rounded-pill nav-btn px-3 nav-link toggle-nav">
           Refreshers
        </a>

        <a href="#productPastryRow"
           class="btn btn-sm rounded-pill nav-btn px-3 nav-link toggle-nav">
           Pastries
        </a>

        <a href="#productPizzaRow"
           class="btn btn-sm rounded-pill nav-btn px-3 nav-link toggle-nav">
           Pizzas
        </a>

        <!-- Cart -->
        <a href="#"
           class="btn btn-sm rounded-pill nav-btn px-3 text-decoration-none"
           data-bs-toggle="offcanvas"
           data-bs-target="#cart"
           aria-controls="cart">
          Cart <i class="bi bi-cart-fill"></i>
        </a>
      </div>

    </div>
  </div>
</div>

<!-- NAVBAR -->  


                

            <!-- Iced Drinks Section -->
            <div class="row g-4" id="productIcedDrinkRow">
                <div style="padding-top: 20px;">
                    <div class="container-fluid">
                        <div class="container text-start">
                            <h1 class="font-playfair fw-bold" style="font-size: 100px;">Iced Drinks</h1>
                            <p>Check out some of our popular Iced Drinks items!</p>
                        </div>
                        <div class="row g-4 iced-drinks-container">
             
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hot Drinks Section -->
            <div class="row g-4" id="productHotDrinkRow">
                <div style="padding-top: 20px;">
                    <div class="container-fluid">
                        <div class="container text-start">
                            <h1 class="font-playfair fw-bold" style="font-size: 100px;">Hot Drinks</h1>
                            <p>Check out some of our popular Hot Drinks items!</p>
                        </div>
                        <div class="row g-4 hot-drinks-container">
                
                        </div>
                    </div>
                </div>
            </div>


            <div class="row g-4" id="productFrappeRow">
                <div style="padding-top: 20px;">
                    <div class="container-fluid">
                        <div class="container text-start">
                            <h1 class="font-playfair fw-bold" style="font-size: 100px;">Frappe's</h1>
                            <p>Check out some of our popular Frappe's items!</p>
                        </div>
                        <div class="row g-4 frappe-drinks-container">
                      
                        </div>
                    </div>
                </div>
            </div>


            <div class="row g-4" id="productRefresherRow">
                <div style="padding-top: 20px;">
                    <div class="container-fluid">
                        <div class="container text-start">
                            <h1 class="font-playfair fw-bold" style="font-size: 100px;">Refresher's</h1>
                            <p>Check out some of our popular Refresher's items!</p>
                        </div>
                        <div class="row g-4 refresher-drinks-container">
                      
                        </div>
                    </div>
                </div>


                <div class="row g-4" id="productPizzaRow">
                <div style="padding-top: 20px;">
                    <div class="container-fluid">
                        <div class="container text-start">
                            <h1 class="font-playfair fw-bold" style="font-size: 100px;">Pizza</h1>
                            <p>Check out some of our popular Pizza items!</p>
                        </div>
                        <div class="row g-4 pizza-container">
                       
                        </div>
                    </div>


                <div class="row g-4" id="productPastaRow">
                <div style="padding-top: 20px;">
                    <div class="container-fluid">
                        <div class="container text-start">
                            <h1 class="font-playfair fw-bold" style="font-size: 100px;">Pasta</h1>
                            <p>Check out some of our popular Pasta items!</p>
                        </div>
                        <div class="row g-4 pasta-container">
                           
                        </div>
                    </div>

                <div class="row g-4" id="productPastryRow">
                <div style="padding-top: 20px;">
                    <div class="container-fluid">
                        <div class="container text-start">
                            <h1 class="font-playfair fw-bold" style="font-size: 100px;">Pastries</h1>
                            <p>Check out some of our popular Pastries items!</p>
                        </div>
                        <div class="row g-4 pastries-container">
                          
                        </div>
                    </div>











        </div>
    </div>

</div>

<!-- Add Product Modal -->
<div class="modal fade" id="add-product-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" method="post" action="add_product.php" enctype="multipart/form-data">
            <div class="col-md-6">
                <label class="form-label">Product Name</label>
                <input type="text" class="form-control" name="productName" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" name="productPrice" required>
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <input type="text" class="form-control" name="productDescription" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Category</label>
                <select name="productCategory" class="form-select" required>
                    <option selected disabled>Choose...</option>
                    <option value="Iced Drink">Iced Drink</option>
                    <option value="Hot Drink">Hot Drink</option>
                    <option value="Frappe">Frappe</option>
                    <option value="Refresher">Refresher</option>
                    <option value="Pastry">Pastry</option>
                    <option value="Pizza">Pizza</option>
                    <option value="Pasta">Pasta</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Image</label>
                <input type="file" class="form-control" name="productImage" accept="image/*" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
    const products = <?php echo json_encode($products); ?>;
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="admin.js"></script>
    

</body>
</html>