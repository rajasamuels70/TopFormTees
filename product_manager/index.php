<?php
$lifetime = 60 * 60 * 24 * 14;
require_once('../model/customer.php');
if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params($lifetime, '/');
    session_start();
}

//session_start();
require_once('../model/database.php');
require_once('../model/product_db.php');
require_once ('../model/order_db.php');

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
else if ($controllerChoice == 'checkout_cart') {
    // Get checkout form values
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $paymentMethod = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);

    // Get logged-in customer from session
    $customer = $_SESSION['customer'] ?? null;

    if (!$customer) {
        $errorMessage = "You must be logged in to complete checkout.";
        include('checkout.php');
        exit();
    }

    // Get cart from session
    $cart = $_SESSION['cart'] ?? [];

    //Calculate subtotal
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    //Calculate tax and shipping
    $tax_rate = 0.0975; // Example: 9.75% sales tax, adjust as needed
    $tax = $subtotal * $tax_rate;
    $shippingFee = 0.00; // Add logic if you have shipping fees

    //Calculate final total
    $total_price = $subtotal + $tax + $shippingFee;

    // Simulate payment status
    if ($paymentMethod === "credit_card") {
        $status = "Completed";
    } elseif ($paymentMethod === "paypal") {
        $status = "Pending";
    } else {
        $errorMessage = "Invalid payment method.";
        include('checkout.php');
        exit();
    }
    // Add order to database with correct calculated values
    require_once('../model/order_db.php');
    $order_id = OrderDB::addOrder($customer->getID(),$address,$city,$state,$postalCode,$total_price,$shippingFee,$tax,$status);

    // Add order items
    foreach ($_SESSION['cart'] as $item) {
        $productId = $item['id'];
        $price = $item['price'];
        $quantity = $item['quantity'];

        OrderDB::addOrderItem($order_id, $productId, $price, $quantity);
    }

    // Optionally clear the cart
    // unset($_SESSION['cart']);

    // Redirect to order success page
    header("Location: ?controllerRequest=order_success&order_id=" . $order_id);
    exit();
}

else if ($controllerChoice == 'order_success') {
    
    
    include('order_success.php'); // Create this file if it doesn't exist
}



else {
    include('index.php'); // Default homepage redirect
}
?>
