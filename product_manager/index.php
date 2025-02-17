<?php

//$lifetime = 60 * 60 * 24 * 14;
//session_set_cookie_params($lifetime, '/');
require_once('../model/database.php');
require_once('../model/product_db.php');  // Assuming product_db handles DB interactions

//session_start();

$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if ($controllerChoice == NULL) {
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ($controllerChoice == NULL) {
        $controllerChoice = 'Not-Set (Null)';
    }
}

if ($controllerChoice == 'product_listing') {
    // Fetch products (this could be done via the product_db model)
    $products = ProductDB::getAllProducts(); // Assuming this returns an array of products

    // Load the products view
    include('product_listing.php');
} 

else if ($controllerChoice == 'product_detail') {
    // Fetch the product details
    $productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $product = ProductDB::getProductById($productId); // Fetch product by ID

    if ($product === null) {
        $errorMessage = "Product not found.";
        include('product_listing.php'); // Display the error on product listing page
    } else {
        // Load the product detail page
        include('product_detail.php');
    }
} 

else {
    // Default action, could be an error or a home page redirect
    include('index.php');
}
?>
