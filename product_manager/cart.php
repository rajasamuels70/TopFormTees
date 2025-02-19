<?php 
session_start();
require_once '../view/header.php'; 

// Remove item from cart
if (isset($_GET['remove'])) {
    $removeID = intval($_GET['remove']);
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $removeID) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
}

// Clear cart
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
}
?>

<section class="cart">
    <h2>Your Shopping Cart</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <p class="empty-cart">Your cart is empty.</p>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><img src="../images/<?php echo htmlspecialchars($item['image']); ?>" width="50"></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <a href="cart.php?remove=<?php echo $item['id']; ?>" class="remove-item">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p class="total-price">Total: $<?php echo number_format($total, 2); ?></p>
        <a href="cart.php?clear=1" class="clear-cart">Clear Cart</a>
        <button class="checkout">Proceed to Checkout</button>
    <?php endif; ?>
</section>

<?php require_once '../view/footer.php'; ?>
