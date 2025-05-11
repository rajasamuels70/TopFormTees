<?php
// Ensure customer is logged in and is an instance of Customer
if (!isset($_SESSION['customer']) || !($_SESSION['customer'] instanceof Customer)) {
    header("Location: ?controllerRequest=login_user");
    exit();
}

$customer = $_SESSION['customer'];

require_once '../view/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Account - Top Form Tees</title>
    <link rel="stylesheet" href="styles/registration.css"> <!-- Use same CSS as Register page -->
</head>
<body>
    <div class="account-header">
        <h1>Welcome, <?php echo htmlspecialchars($customer->getFirstName()); ?>!</h1>
        <nav>
            <ul>
                <li><a href="customer_manager?controllerRequest=dashboard">Dashboard</a></li>
                <li><a href="customer_manager?controllerRequest=edit_account">Edit Account</a></li>
<!--                <li><a href="view_orders.php">Your Orders</a></li>-->
            </ul>   
        </nav>
    </div>

    <main>
        <div class="form-container">
<!--            <h2>Edit Your Account</h2>-->

            <?php if (!empty($errorMessage)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>

            <form method="POST" action="customer_manager/index.php" >
                <input type="hidden" name="controllerRequest" value="update_account" />
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" class="form-control" required
                    value="<?php echo htmlspecialchars($customer->getFirstName()); ?>">

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" class="form-control" required
                    value="<?php echo htmlspecialchars($customer->getLastName()); ?>">

                <label for="emailAddress">Email:</label>
                <input type="email" id="emailAddress" name="emailAddress" class="form-control" required
                    value="<?php echo htmlspecialchars($customer->getEmailAddress()); ?>">

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" class="form-control"
                    value="<?php echo htmlspecialchars($customer->getAddress()); ?>">

                <label for="city">City:</label>
                <input type="text" id="city" name="city" class="form-control"
                    value="<?php echo htmlspecialchars($customer->getCity()); ?>">

                <label for="state">State:</label>
                <input type="text" id="state" name="state" class="form-control"
                    value="<?php echo htmlspecialchars($customer->getState()); ?>">

                <label for="postalCode">Postal Code:</label>
                <input type="text" id="postalCode" name="postalCode" class="form-control"
                    value="<?php echo htmlspecialchars($customer->getZip()); ?>">

                <input type="submit" value="Update Account">
            </form>
        </div>
    </main>

    <?php require_once '../view/footer.php'; ?>
</body>
</html>
