<?php
$order_id = filter_input(INPUT_GET, 'order_id', FILTER_VALIDATE_INT);
?>
<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmed</title>
     Shared styles will load from header.php 
</head>-->
<?php include '../view/header.php'; ?>
<body>
    

    <!-- Custom CSS loaded after header to ensure it overrides shared styles -->
    <link rel="stylesheet" href="./styles/orderconfirmed.css">

    <div class="container">
        <h1>Thank You for Your Order!</h1>
        <p>Your order has been successfully placed.</p>

        <?php if ($order_id): ?>
            <div class="order-summary">
                <p><strong>Order ID:</strong> #<?php echo htmlspecialchars($order_id); ?></p>
                <p>We've sent a confirmation email with your order details.</p>
            </div>
        <?php else: ?>
            <p class="error">There was an issue retrieving your order information.</p>
        <?php endif; ?>
            
        <a href="product_manager?controllerRequest=product_listing">
            <button class="btn-home">Continue Shopping</button>
        </a>
    </div>

    <?php include '../view/footer.php'; ?>
</body>
</html>
