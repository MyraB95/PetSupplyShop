<?php require_once("../resources/config.php"); ?>

<?php 
include(TEMPLATE_FRONT . DS . "header.php");
log_interaction($_GET['id'], "view", $connection); 
?>

<!-- Page Content -->
<div class="container">

    <!-- Side Navigation -->
    <?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>

    <?php 
    $product_id = escape_string($_GET['id']);  // Securely get the product ID from GET
    $query = query("SELECT * FROM products WHERE product_id='$product_id' ");
    confirm($query);

    // Fetch the product data
    $product_data = fetch_array($query);

    // Check if product data exists
    if ($product_data) :
    ?>

    <div class="col-md-9">
        <!--Row For Image and Short Description-->
        <div class="row">
            <div class="col-md-7">
                <img class="img-responsive" src="<?php echo htmlspecialchars($product_data['product_image']); ?>" alt="">
            </div>
            <div class="col-md-5">
                <div class="thumbnail">
                    <div class="caption-full">
                        <!-- Ensure proper separation of title and price -->
                        <h4><a href="#"><?php echo htmlspecialchars($product_data['product_title']); ?></a></h4>
                        <hr>
                        <h4 class=""><?php echo "&#36;" . htmlspecialchars($product_data['product_price']); ?></h4>
                        <p><?php echo htmlspecialchars($product_data['short_desc']); ?></p>
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="button" class="btn btn-primary" value="Purchase" onclick="addToCart(<?php echo $product_data['product_id']; ?>, '<?php echo addslashes($product_data['product_title']); ?>', <?php echo $product_data['product_price']; ?>)">
                                <button type="button" class="btn btn-default" onclick="addToFavorites(<?php echo $product_data['product_id']; ?>)">❤ Favorite</button>
                            </div>
                        </form>
                        <div id="thankYouMessage" style="display:none;"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row For Image and Short Description-->
        <hr>
        <!-- More content goes here -->
    </div>

    <?php 
    else :
        echo "<p>Product not found.</p>";
    endif;
    ?>

</div>
<!-- /.container -->

<script>
    // Function to show the thank you message
    function addToCart(productId, title, price) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_to_cart.php', true); // PHP script to handle database update
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
                document.getElementById('thankYouMessage').innerHTML = "<p>" + xhr.responseText + "</p>"; 
                document.getElementById('thankYouMessage').style.display = 'block';
            }
        };
        xhr.send('productId=' + productId + "&title=" + encodeURIComponent(title) + "&price=" + price);
        document.getElementById('thankYouMessage').innerHTML = "<p>Thanks for your purchase!</p>";
        document.getElementById('thankYouMessage').style.display = 'block';
    }

    // Function to add to favorites
    function addToFavorites(productId) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_to_my_favorite.php', true); // PHP script to handle database update
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
                document.getElementById('thankYouMessage').innerHTML = "<p>" + xhr.responseText + "</p>"; 
                document.getElementById('thankYouMessage').style.display = 'block';
            }
        };
        xhr.send('productId=' + productId);
    }
</script>

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>

