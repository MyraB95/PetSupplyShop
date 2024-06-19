<?php 
$page = 0;
$limit = 30;  
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page']; 
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $connection->prepare("DELETE FROM categories WHERE cat_id=?");
    $query->bind_param("i", $id);
    $query->execute();
}

$query = query("SELECT 
categories.cat_id,
categories.cat_title,
parent.cat_title as parent_title
FROM categories  
LEFT JOIN categories as parent ON parent.cat_id = categories.parent
LIMIT ".$page*$limit.",$limit");

$categories = $query->fetch_all(MYSQLI_ASSOC);
?>
       
<div class="col-md-12">
    <div class="row">
        <h1 class="page-header">
            All categories
        </h1>
    </div>

    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Parent</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $category) : ?>
                <tr>
                    <?php if (isset($category['cat_id'])): ?>
                        <td><?=$category['cat_id'];?></td>
                    <?php endif; ?>
                    <td><a href="index.php?category&id=<?= $category['cat_id'];?>"><?=$category['cat_title'];?></a></td>
                    <td><?=$category['parent_title'];?></td>
                    <td>
                        <a class='btn btn-success' href='index.php?category&id=<?= $category['cat_id']; ?> '>
                            Edit
                        </a>&nbsp;&nbsp;&nbsp;
                        <a class='btn btn-danger' href='index.php?categories&id=<?= $category['cat_id']; ?> '>
                            Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>




