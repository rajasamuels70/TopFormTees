<?php 
//session_start();
require_once '../view/header.php';

// At this point, $product has been fetched by the controller.
if (!$product) {
    echo "<p class='error'>Product not found.</p>";
    require_once '../view/footer.php';
    exit();
}

// Handle "Add to Cart"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cartItem = [
        'id'       => $product['ProductID'],
        'name'     => $product['Description'],
        'price'    => $product['Price'],
        'quantity' => $_POST['quantity'],
        'size'     => isset($_POST['size']) ? $_POST['size'] : '',
        'image'    => $product['Description']
    ];

    // Initialize cart if empty
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product with the same size is already in the cart and update quantity
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product['ProductID'] && $item['size'] == $cartItem['size']) {
            $item['quantity'] += $_POST['quantity'];
            $found = true;
            break;
        }
    }
    if (!$found) {
        $_SESSION['cart'][] = $cartItem;
    }

    $successMessage = "Product added to cart!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>  
    <link rel="stylesheet" type="text/css" href="styles/product_detail.css">
</head>
<body>
<section class="product-detail">
    <div class="product-container">
        <img src="images/<?php echo strtolower(str_replace(' ', '-', $product['Description'])); ?>.jpg" 
             alt="<?php echo htmlspecialchars($product['Description']); ?>">
        <div class="product-info">
            <h2><?php echo htmlspecialchars($product['Description']); ?></h2>
            <p class="price">$<?php echo number_format($product['Price'], 2); ?></p>
            <p class="availability">
                <?php echo ($product['isActive']) ? '' : 'Out of Stock'; ?>
            </p>

            <?php if (!empty($successMessage)) echo "<p class='success'>$successMessage</p>"; ?>

            <form method="POST" action="">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" required>
                

                <?php if (!empty($product['Size'])): ?>
                    <?php 
                        // Convert the comma-separated sizes into an array
                        $sizes = explode(',', $product['Size']); 
                    ?>
                <br/>
                <br/>
                <div>
                    <label for="size">Size:</label>
                    <select name="size" id="size" required>
                        <?php foreach ($sizes as $size): ?>
                            <option value="<?php echo trim($size); ?>"><?php echo trim($size); ?></option>
                        <?php endforeach; ?>
                    </select>
                <div/> 
                    
                <?php endif; ?>

                <button type="submit" class="add-to-cart">Add to Cart</button>
            </form>
            <!-- View Cart Button (Styled to Match Your Design) -->
            
        </div>
    </div>
                <a href="product_manager?controllerRequest=view_cart">
                    <button type="submit" class="view-cart">View Cart</button>
                </a>
</section>
<?php require_once '../view/footer.php'; ?>
</body>
</html>
