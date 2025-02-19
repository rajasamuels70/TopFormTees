<?php 
session_start();
require_once '../view/header.php';
require_once '../model/product_db.php'; 


// Get product ID from URL
$productID = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$product = ProductDB::getProductById($productID);

if (!$product) {
    echo "<p class='error'>Product not found.</p>";
    require_once '../view/footer.php';
    exit();
}

// Handle "Add to Cart"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cartItem = [
        'id' => $product['ProductID'],
        'name' => $product['Description'],
        'price' => $product['Price'],
        'quantity' => $_POST['quantity'],
        'image' => $product['image']
    ];

    // Initialize cart if empty
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product is already in cart and update quantity
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productID) {
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
<head>
    <link rel="stylesheet" type="text/css" href="styles/product_detail.css">
</head>

<section class="product-detail">
    <div class="product-container">
        <img src="../images/<?php echo htmlspecialchars($product['image']); ?>" 
             alt="<?php echo htmlspecialchars($product['Description']); ?>" class="product-image">
        <div class="product-info">
            <h2><?php echo htmlspecialchars($product['Description']); ?></h2>
            <p class="price">$<?php echo number_format($product['Price'], 2); ?></p>
            <p class="category">Category: <?php echo htmlspecialchars($product['CategoryID']); ?></p>
            <p class="availability">
                <?php echo ($product['isActive']) ? 'Available' : 'Out of Stock'; ?>
            </p>

            <?php if (!empty($successMessage)) echo "<p class='success'>$successMessage</p>"; ?>

            <form method="POST" action="">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" required>
                <button type="submit" class="add-to-cart">Add to Cart</button>
            </form>
        </div>
    </div>
</section>

<?php require_once '../view/footer.php'; ?>
