<?php
session_start();
require_once '../view/header.php'; // Include site header for consistency

// Ensure the cart is initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Remove Item
if (isset($_POST['remove_id'])) {
    $removeID = intval($_POST['remove_id']);
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $removeID) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
            break;
        }
    }
}

// Handle Update Quantities
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $qty) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantity'] = max(1, intval($qty)); // Ensure min quantity of 1
                break;
            }
        }
    }
}

// Calculate total cart price
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}
?>

<!-- Link to Cart Stylesheet -->
<link rel="stylesheet" href="styles/cart.css">

<div class="cart-container">
    <h2>Shopping Cart</h2>

    <?php if (empty($_SESSION['cart'])) : ?>
        <p class="empty-cart">Your cart is empty.</p>
        <div class="cart-buttons">
            <a href="product_manager?controllerRequest=product_listing">
                <button class="continue">Continue Shopping</button>
            </a>
        </div>
    <?php else : ?>
        <form method="POST">
            <table class="cart-table">
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>

                <?php foreach ($_SESSION['cart'] as $item) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['size']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        <td>
                            <button type="submit" name="remove_id" value="<?php echo $item['id']; ?>" class="remove-button">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td colspan="3" align="right"><strong>Total:</strong></td>
                    <td><strong>$<?php echo number_format($totalPrice, 2); ?></strong></td>
                    <td></td>
                </tr>
            </table>

        </form>
        <div class="cart-buttons">
                <button type="submit" name="update_cart" class="update">Update Cart</button>
                
                <a href="product_manager?controllerRequest=product_listing">
                    <button class="continue">Continue Shopping</button>
                </a>
                <a href="product_manager?controllerRequest=checkout_cart">
                    <button class="checkout">Proceed to Checkout</button>
                </a>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../view/footer.php'; // Include footer for consistent design ?>
