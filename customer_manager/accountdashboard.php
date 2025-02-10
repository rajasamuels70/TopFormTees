<?php
// Ensure session is started only if it's not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure customer is logged in and is an instance of Customer
if (!isset($_SESSION['customer']) || !($_SESSION['customer'] instanceof Customer)) {
    header("Location: ?controllerRequest=login_user");
    exit();
}

$customer = $_SESSION['customer'];

require_once '../view/header.php';
require_once('../model/order_db.php');
require_once('../model/order.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Dashboard - Top Form Tees</title>
    <link rel="stylesheet" type="text/css" href="styles/dashboard.css">
</head>
<body>
    <div class="account-header">
        <h1>Welcome, <?php echo htmlspecialchars($customer->getFirstName()); ?>!</h1>
        <nav>
            <ul>
                <li><a href="customer_manager?controllerRequest=dashboard">Dashboard</a></li>
                <li><a href="edit_account.php">Edit Account</a></li>
                <li><a href="view_orders.php">Your Orders</a></li>
            </ul>   
        </nav>
    </div>

    <main>
        <section>
            <h2>Your Account Information</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($customer->getFirstName()) . " " . htmlspecialchars($customer->getLastName()); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($customer->getEmailAddress()); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($customer->getAddress()); ?></p>
            <p><strong>Account Created:</strong> <?php echo htmlspecialchars($customer->getDateAdded()); ?></p>
        </section>

        <section>
            <h2>Your Orders</h2>
            <?php
            // Fetch orders for the logged-in customer
            $orders = OrderDB::getOrdersByCustomerId($customer->getId());

            if (!empty($orders)) {
                echo "<table border='1'>";
                echo "<tr>
                        <th>Order ID</th>
                        <th>Total Cost</th>
                        <th>Date Ordered</th>
                        <th>Products</th>
                      </tr>";

                foreach ($orders as $order) {
                    $orderDetails = OrderDB::getOrderWithProduct($order->getOrderId()); // Fetch products in the order
                    
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($order->getOrderId()) . "</td>";
                    echo "<td>$" . number_format($order->getTotalCost(), 2) . "</td>";
                    echo "<td>" . htmlspecialchars($order->getDateOrdered()) . "</td>";
                    echo "<td>";
                    
                    if (!empty($orderDetails)) {
                        echo "<ul>";
                        foreach ($orderDetails as $detail) {
                            echo "<li>" . htmlspecialchars($detail['Description']) . 
                                 " - " . htmlspecialchars($detail['Quantity']) . " x $" . 
                                 number_format($detail['Price'], 2) . "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "No products found.";
                    }

                    echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>You have not placed any orders yet.</p>";
            }
            ?>
        </section>

        <section>
            <h2>Settings</h2>
            <p>If you need to change your account information, you can <a href="edit_account.php">edit your account</a> or <a href="change_password.php">change your password</a>.</p>
        </section>
    </main>
</body>
</html>
