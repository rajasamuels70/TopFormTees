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

else {
    include('index.php'); // Default homepage redirect
}
?>
