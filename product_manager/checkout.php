<?php
require_once '../model/order_db.php';
//require_once '../model/usps_api.php';

// Retrieve cart items from session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_price = 0;

// Retrieve customer info if logged in
$customer = isset($_SESSION['customer']) ? $_SESSION['customer'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Top Form Tees</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/checkout.css">
    <script>
        const customerZip = "<?php echo htmlspecialchars($customer ? $customer->getZip() : ''); ?>";
    </script>
</head>
<body>
    <?php include '../view/header.php'; ?>
    
    <main class="container">
        <section class="checkout-section">
            <h2 class="section-title">Checkout</h2>
            
            <form id="checkout-form" method="POST" action="product_manager/index.php" class="checkout-form">
                <input type="hidden" name="controllerRequest" value="checkout_cart">

                
                <?php if ($customer): ?>
                <div class="user-info card">
                    <h3>Shipping Details</h3>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($customer->getFirstName()) . " " . htmlspecialchars($customer->getLastName()); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($customer->getEmailAddress()); ?></p>
                    <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($customer->getAddress()) . ", " . htmlspecialchars($customer->getCity()) . " " . htmlspecialchars($customer->getState()) . " " . htmlspecialchars($customer->getZip()); ?></p>
                    

                    <!-- Hidden fields to pass data -->
                        <input type="hidden" name="address" value="<?php echo htmlspecialchars($customer->getAddress()); ?>">
                        <input type="hidden" name="city" value="<?php echo htmlspecialchars($customer->getCity()); ?>">
                        <input type="hidden" name="state" value="<?php echo htmlspecialchars($customer->getState()); ?>">
                        <input type="hidden" name="postalCode" value="<?php echo htmlspecialchars($customer->getZip()); ?>">
                    </div>
                    
                    
                </div>
                <?php else: ?>
                <p class="error">Please log in to proceed with checkout.</p>
                <?php endif; ?>
                
                <h3>Cart Items</h3>
                    <ul class="cart-list">
                        <?php foreach ($cart as $item): ?>
                            <?php  
                                $line_total = $item['price'] * $item['quantity'];
                                $total_price += $line_total;
                            ?>
                            <li class="cart-item">
                                <span class="item-name"><?php echo htmlspecialchars($item['name']); ?> (x<?php echo htmlspecialchars($item['quantity']); ?>)</span>
                                <span class="item-price">$<?php echo number_format($line_total, 2); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="subtotal-price">Subtotal: <strong>$<span id="subtotal"><?php echo number_format($total_price, 2); ?></span></strong></p>
                    <p class="sales-tax">Sales Tax: <strong>$<span id="sales-tax">0.00</span></strong></p>
                    <p class="final-total">Total Including Tax: <strong>$<span id="final-total"><?php echo number_format($total_price, 2); ?></span></strong></p>


                <h3>Payment Method</h3>
                <div class="payment-options">
                    <label>
                        <input type="radio" name="payment_method" value="credit_card" required onclick="showPaymentForm('credit_card')"> Credit Card
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="paypal" required onclick="showPaymentForm('paypal')"> PayPal
                    </label>
                </div>

                <!-- Updated Credit Card Form -->
                    <div id="credit-card-form" style="display: none;">
                        <h3>Enter Credit Card Details</h3>

                        <!-- Card Type Selection -->
                        <label for="card-type">Card Type:</label>
                        <select id="card-type">
                            <option value="">Select Card Type</option>
                            <option value="visa">Visa</option>
                            <option value="mastercard">MasterCard</option>
                            <option value="amex">American Express</option>
                            <option value="discover">Discover</option>
                        </select>

                        <!-- Card Number -->
                        <input type="text" id="card-number" placeholder="Card Number" maxlength="19" oninput="formatCardNumber()" value="4111111111111111">

                        <!-- Expiry & CVV -->
                        <div class="card-details">
                            <input type="text" id="card-expiry" placeholder="MM/YY" maxlength="5" value="09/29">
                            <input type="text" id="card-cvv" placeholder="CVV" maxlength="4" value="445">
                        </div>

                        <!-- Validation Result -->
                        <p id="card-result"></p>

                        <!-- Checkout Button -->
                        <button id="validate-card" class="btn primary-btn">Checkout</button>
                    </div>


                <!-- PayPal Button Placeholder -->
                <div id="paypal-button-container" style="display: none;">
                    <button type="submit" class="btn primary-btn">Pay with PayPal</button>
                </div>

                <button type="submit" id="place-order-btn" class="btn primary-btn">Place Order</button>
            </form>
        </section>
    </main>
    
    <?php include '../view/footer.php'; ?>
    <script src="../TopFormTees/scripts/checkout.js"></script>



</body>
</html>
