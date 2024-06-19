<?php 

$data =(Object) ['product_id'=>'','product_title'=>'','product_price'=>0,"product_quantity"=>0,'product_description'=>'','short_desc'=>'','product_image'=>'','product_cat_id'=>0]; 



if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $img = ""; 
  if(isset($_FILES['file'])){
    if ($_FILES['file']['error'] == 0){
      $file_name = $_FILES['file']['name'];
      $file_tmp = $_FILES['file']['tmp_name'];
     move_uploaded_file($file_tmp,SITE_BASE."/images/".$file_name);
     $img = "images/".$file_name; 

    }
  }

  
  if ($_POST['publish'] == "Edit"){

    $query = $connection->prepare("UPDATE products  SET  product_title=?,product_price=?,product_quantity=?,product_description=?,short_desc=?,product_image=?,product_cat_id=? WHERE product_id=$_GET[id]");

  }else{
  $query = $connection->prepare("INSERT INTO products ( product_title,product_price,product_quantity,product_description,short_desc,product_image,product_cat_id) 
  
  VALUES ( ?,?,?,?,?,?,?)");
 
  }
  if ($img == ""){
    $img = $_POST['product_image'];
  }
  $query->bind_param("siissss", $_POST['product_title'], $_POST['product_price'], $_POST['product_quantity'], $_POST['product_description'], $_POST['short_desc'],$img, $_POST['product_cat_id']);
  $query->execute();
  redirect("index.php?products");


}


if (isset($_GET['id'])){
  $query  =  query("SELECT *FROM products where product_id=$_GET[id]");
  $data = $query->fetch_object();
  }
  $query  =  query("SELECT *FROM categories");
$categories = $query->fetch_all(MYSQLI_ASSOC);
?>

<div class="col-md-12">

<div class="row">
<h1 class="page-header">
<?php if ($data->product_id ==""){  echo "Publish";} else {echo "Edit";}?> product

</h1>
</div>        
<form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Product Title </label>
        <input type="text" name="product_title" value="<?= $data->product_title ;?>" class="form-control">
       
    </div>

 <div class="form-group">
           <label for="product-title">Short Description</label>
      <textarea name="short_desc"  id="" cols="30" rows="3" class="form-control">

      <?= $data->short_desc ;?>
      </textarea>
    </div>
    <div class="form-group">
           <label for="product-title">Product Description</label>
      <textarea name="product_description"  id="" cols="30" rows="10" class="form-control">

      <?= $data->product_description ;?>
      </textarea>
    </div>



    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Product Price</label>
        <input type="text" name="product_price" value=" <?= $data->product_price ;?>" class="form-control" size="60">
      </div>
    </div>

     <div class="form-group row">

      <div class="col-xs-3">
        <label for="product_quantity">Product Quantity</label>
        <input type="text" name="product_quantity" value=" <?= $data->product_quantity ;?>" class="form-control" size="60">
      </div>
    </div>

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     
     <div class="form-group">
     <input type="submit" name="publish" class="btn btn-primary btn-lg" value="<?php if ($data->product_id ==""){  echo "Publish";} else {echo "Edit";}?>">
    </div>


     <!-- Product Categories-->
     <div class="form-group">
         <label for="product-title">Category</label>
        <select name="product_cat_id" id="" class="form-control">

            <option value="0">Select category</option>
            <?php foreach ($categories as $key => $value):?> 
              <option value="<?= $value['cat_id']; ?>"  <?php if ( $value['cat_id'] == $data->product_cat_id){echo "selected";}?> ><?= $value['cat_title']; ?></option>
              <?php endforeach; ?>
        </select>
    </div>





    <!-- Product Brands-->


  


<!-- Product Tags -->


    <div class="form-group">
          <label for="product-url">Product image url </label>
        <input type="text" name="product_image"  value=" <?= $data->product_image ;?>" class="form-control">
    </div>

    <!-- Product Image -->
    <div class="form-group">
        <label for="product-title">Product Image</label>
        <input type="file" name="file">
      
    </div>
    



</aside><!--SIDEBAR-->


    
</form>


           