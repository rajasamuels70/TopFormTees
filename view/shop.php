<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Top Form Tees</title>
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>

<?php include 'header.php'; ?>

<main>
    <h2>Shop Our Collection</h2>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="../images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p>$<?php echo number_format($product['price'], 2); ?></p>
                <a href="product.php?id=<?php echo $product['id']; ?>" class="buy-button">View Product</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>