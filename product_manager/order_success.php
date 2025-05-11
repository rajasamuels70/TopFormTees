<?php
require_once '../model/order_db.php';
require_once '../model/order.php';

$order_id = filter_input(INPUT_GET, 'order_id', FILTER_VALIDATE_INT);

$order = null;
$order_items = [];

if ($order_id) {
    $order = OrderDB::getOrderById($order_id);
    $order_items = OrderDB::getOrderWithProduct($order_id); // includes quantity, price, description
}

// Retrieve customer info if logged in
$customer = isset($_SESSION['customer']) ? $_SESSION['customer'] : null;
?>

<?php include '../view/header.php'; ?>
<link rel="stylesheet" href="./styles/orderconfirmed.css">

<body>
<div class="container">
    <h1>Thank You for Your Order!</h1>

    <?php if ($order && !empty($order_items)): ?>
        <div class="order-summary">
            <p><strong>Order ID:</strong> #<?php echo htmlspecialchars($order->getOrderID()); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($order->getDateOrdered()); ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($customer->getFirstName()) . " " . htmlspecialchars($customer->getLastName()); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($customer->getEmailAddress()); ?></p>
            <p><strong>Shipping Address:</strong><br>
                <?php echo htmlspecialchars($customer->getAddress()) . ", " 
                        . htmlspecialchars($customer->getCity()) . " " 
                        . htmlspecialchars($customer->getState()) . " " 
                        . htmlspecialchars($customer->getZip());
                ?>
            </p>

            <h3>Items Ordered</h3>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $subtotal = 0;
                    foreach ($order_items as $item):
                        $line = $item['Price'] * $item['Quantity'];
                        $subtotal += $line;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['Description']); ?></td>
                        <td>$<?php echo number_format($item['Price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($item['Quantity']); ?></td>
                        <td>$<?php echo number_format($line, 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php
            $tax = $order->getTax();
            $shipping = $order->getShippingFee();
            $total = $subtotal + $tax + $shipping;
            ?>

            <div class="totals">
                <p><strong>Subtotal:</strong> $<?php echo number_format($subtotal, 2); ?></p>
                <p><strong>Tax:</strong> $<?php echo number_format($tax, 2); ?></p>
                <p><strong>Shipping:</strong> $<?php echo number_format($shipping, 2); ?></p>
                <hr>
                <p class="total"><strong>Total:</strong> $<?php echo number_format($total, 2); ?></p>
            </div>

            <p class="confirmation-note">A confirmation email has been sent to you with your order summary.</p>
        </div>
    <?php else: ?>
        <p class="error">Sorry, we couldn't find details for this order.</p>
    <?php endif; ?>

    <a href="product_manager?controllerRequest=product_listing">
        <button class="btn-home">Continue Shopping</button>
    </a>
</div>

<?php include '../view/footer.php'; ?>
</body>
</html>
