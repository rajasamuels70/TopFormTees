<?php
session_start();
require_once '../model/database.php';
require_once '../model/order_db.php';
require_once '../model/product_db.php';

// Retrieve cart items from session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_price = 0;

// Retrieve customer info if logged in
$customer = isset($_SESSION['customer']) && is_array($_SESSION['customer']) ? $_SESSION['customer'] : [];
$name = isset($customer['name']) ? $customer['name'] : 'Guest';
$email = isset($customer['email']) ? $customer['email'] : 'Not Provided';
$address = isset($customer['address']) ? $customer['address'] : 'Not Provided';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Top Form Tees</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/checkout.css">
</head>
<body>
    <?php include '../view/header.php'; ?>
    <div class="checkout-container">
        <h2>Checkout</h2>
        <form method="POST" action="../index.php">
            <input type="hidden" name="action" value="process_checkout">
            
            <div class="user-info">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($address); ?></p>
            </div>
            
            <h3>Cart Items</h3>
            <ul class="cart-list">
                <?php foreach ($cart as $item): ?>
                    <li>
                        <span class="item-name"> <?php echo $item['name']; ?> </span>
                        <span class="item-price"> $<?php echo number_format($item['price'], 2); ?> </span>
                    </li>
                    <?php $total_price += $item['price']; ?>
                <?php endforeach; ?>
            </ul>
            <p class="total-price">Total: <strong>$<?php echo number_format($total_price, 2); ?></strong></p>
            
            <label>Payment Method:</label>
            <div class="payment-options">
                <input type="radio" id="credit_card" name="payment_method" value="credit_card" required>
                <label for="credit_card">Credit Card</label>
                
                <input type="radio" id="paypal" name="payment_method" value="paypal" required>
                <label for="paypal">PayPal</label>
            </div>
            
            <button type="submit" class="checkout-btn">Place Order</button>
        </form>
    </div>
    <?php include '../view/footer.php'; ?>
</body>
</html>
