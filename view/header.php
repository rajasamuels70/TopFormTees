<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Form Tees</title>  
    <base href="http://localhost/Projects/TopFormTees/">
    <link rel="stylesheet" type="text/css" href="styles/main.css">
</head>
<body>
    <header>
        <h1>Top Form Tees</h1>
        <nav>
            <nav>
    <ul>
        <li><a href="index.php">Home</a></li>

        <?php if (!isset($_SESSION['customer'])): ?>
            <li><a href="customer_manager?controllerRequest=login_user">Login</a></li>
            <li><a href="customer_manager?controllerRequest=add_user">Register</a></li>
        <?php endif; ?>

        <li><a href="product_manager?controllerRequest=product_listing">Shop</a></li>
        
        <li><a href="customer_manager?controllerRequest=contact_us">Contact Us</a></li>

        <?php if (isset($_SESSION['customer'])): ?>
            <li><a href="customer_manager?controllerRequest=dashboard">Dashboard</a></li>
            <li><a href="product_manager?controllerRequest=view_cart">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></li>
            <li><a href="customer_manager?controllerRequest=logout">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>

        </nav>
    </header>
</body>

