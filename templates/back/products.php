<?php
// Assuming $connection is your database connection object

$page = 0;
$limit = 60;

if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $productId = $_GET['id'];
    $deleteQuery = $connection->prepare("DELETE FROM products WHERE product_id = ?");
    $deleteQuery->bind_param("i", $productId);
    $deleteQuery->execute();
}

$query = $connection->query("SELECT 
    products.*,
    categories.cat_title as category
    FROM products   
    LEFT JOIN categories ON categories.cat_id = products.product_cat_id
    LIMIT " . $page * $limit . ", $limit;
");
$products = $query->fetch_all(MYSQLI_ASSOC);
?>

<!-- HTML part -->

<div class="col-md-12">
    <div class="row">
        <h1 class="page-header">
            All Products
        </h1>
    </div>

    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Photo</th>
                    <th>Short description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?= $product['product_id']; ?></td>
                        <td><a href="index.php?product&id=<?= $product['product_id']; ?>"><?= $product['product_title']; ?></a></td>
                        <td>
                            <?php
                            $img = $product['product_image'];
                            $url = $product['product_image'];
                            if (substr($url, 0, 7) == "http://") {
                                $url = "http";
                            }

                            if (substr($url, 0, 8) == "https://") {
                                $url = "https";
                            }

                            if ($url != 'https' && $url != 'http') {
                                $img = SITE_URl . $product['product_image'];
                            }
                            ?>
                            <img src="<?= $img; ?>" height="70" alt="">
                        </td>
                        <td><?= $product['short_desc']; ?></td>
                        <td><?= $product['product_price']; ?></td>
                        <td><a href=""><?= $product['product_quantity']; ?></a></td>
                        <td><?= $product['category']; ?></td>
                        <td>
                            <a class='btn btn-success' href='index.php?product&id=<?= $product['product_id']; ?>'>
                                Edit
                            </a>
                        </td>
                        <td>
                            <a class='btn btn-danger' href='index.php?products&id=<?= $product['product_id']; ?>'>
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>



