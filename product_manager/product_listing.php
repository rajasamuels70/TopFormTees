<?php 
require_once '../view/header.php';
require_once '../model/product_db.php'; // Use the existing ProductDB class

// Fetch products using ProductDB class
$products = ProductDB::getAllProducts();
?>
<head>
    <link rel="stylesheet" type="text/css" href="styles/products.css">
</head>
<section class="product-listing">
    <h2>Browse Our Products</h2>
    <div class="product-grid">
        <?php
        if (!empty($products)) {
            foreach ($products as $product) {
                ?>
                <div class="product-card">
                    <img src="images/<?php echo strtolower(str_replace(' ', '-', $product['Description'])); ?>.jpg" 
                         alt="<?php echo htmlspecialchars($product['Description']); ?>">
                    <h3><?php echo htmlspecialchars($product['Description']); ?></h3>
                    <p class="price">$<?php echo number_format($product['Price'], 2); ?></p>
                    <a href="?controllerRequest=product_detail&id=<?php echo htmlspecialchars($product['ProductID']); ?>" 
                       class="view-details">View Details</a>
                </div>
                <?php
            }
        } else {
            echo "<p class='error'>No products available at this time.</p>";
        }
        ?>
    </div>
</section>

<?php require_once '../view/footer.php'; ?>
