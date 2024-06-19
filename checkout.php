<?php
require_once("../resources/config.php");
require_once("cart.php");
include(TEMPLATE_FRONT . DS . "header.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
}
?>

<div class="container">
    <div class="row">
        <h1>Checkout</h1>
        <!-- Cart table -->
        <form action="">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Sub-total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Call the 'cart' function to display cart items
                    cart();
                    ?>
                    <!-- Other product rows -->
                </tbody>
            </table>
        </form>

        <!-- Cart totals -->
        <div class="col-xs-4 pull-right">
            <h2>Cart Totals</h2>
            <table class="table table-bordered" cellspacing="0">
                <tbody>
                    <!-- Cart subtotal -->
                    <tr class="cart-subtotal">
                        <th>Items:</th>
                        <td>
                            <span class="amount">
                                <?php
                                $totalItems = 0;
                                if (isset($_SESSION['cart'])) {
                                    foreach ($_SESSION['cart'] as $product) {
                                        $totalItems += $product['quantity'];
                                    }
                                }
                                echo $totalItems;
                                ?>
                            </span>
                        </td>
                    </tr>
                    <!-- Shipping -->
                    <tr class="shipping">
                        <th>Shipping and Handling</th>
                        <td>Free Shipping</td>
                    </tr>
                    <!-- Order total -->
                    <tr class="order-total">
                        <th>Order Total</th>
                        <td>
                            <strong>
                                <span class="amount">
                                    <?php
                                    $orderTotal = calculateOrderTotal();
                                    echo '$' . number_format($orderTotal, 2);
                                    ?>
                                </span>
                            </strong>
                        </td>
                    </tr>
                </tbody>
            </table>

           <!-- Purchase button -->
<form action="" method="post" onsubmit="showThankYouMessage(event)">
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Purchase">
    </div>
</form>

<!-- Hidden thank you message -->
<div id="thankYouMessage" style="display:none;">
    <p>Thanks for your purchase!</p>
</div>

<!-- JavaScript -->
<script>
    function showThankYouMessage(event) {
        event.preventDefault(); // Prevent form submission

        // Show the thank you message
        document.getElementById('thankYouMessage').style.display = 'block';
    }
</script>


            <!-- Hidden thank you message -->
            <div id="thankYouMessage" style="display:none;">
                <p>Thanks for your purchase!</p>
            </div>
        </div>
    </div>
</div>

<!-- Script for displaying thank you message -->
<script>
    // ... (unchanged)
</script>

<!-- Footer -->
<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>
