<?php

require_once('../model/database.php');
require_once('../model/product_db.php'); 

$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if ($controllerChoice == NULL) {
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ($controllerChoice == NULL) {
        $controllerChoice = 'Not-Set (Null)';
    }
}

// Debugging Output - Remove after testing
error_log("Controller Request: " . $controllerChoice);

if ($controllerChoice == 'product_listing') {
    $products = ProductDB::getAllProducts();
    include('product_listing.php');
} 

else if ($controllerChoice == 'product_detail') {
    // Fetch the product details
    $productID = filter_input(INPUT_GET, 'ProductID', FILTER_VALIDATE_INT);

    if ($productID) {
        $product = ProductDB::getProductById($productID);
        
        if ($product) {
            
            include('product_detail.php'); // Load product details
        } else {
            $errorMessage = "Product not found.";
            include('product_listing.php'); // Redirect to product list
        }
    } else {
        $errorMessage = "Invalid product ID.";
        include('product_listing.php');
    }
}
else if ($controllerChoice == 'view_cart'){
    include('cart.php'); // Load cart view
}
else if ($controllerChoice == 'checkout_cart'){
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $emailAddress = filter_input(INPUT_POST, 'emailAddress', FILTER_VALIDATE_EMAIL);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    include('checkout.php'); // Load cart view
}

else {
    include('index.php'); // Default homepage redirect
}
?>
