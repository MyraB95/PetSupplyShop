<?php 

$data =(Object) ['cat_id'=>'','cat_title'=>'','parent'=>0]; 



if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if ($_POST['publish'] == "Edit"){
    $query = $connection->prepare("UPDATE categories  SET  cat_title=?, parent=? WHERE cat_id=$_GET[id]");

  }else{
  $query = $connection->prepare("INSERT INTO categories ( cat_title, parent) VALUES ( ?, ?)");
 
  }
  $query->bind_param("si", $_POST['cat_title'], $_POST['parent']);
  $query->execute();
  redirect("index.php?categories");


}


if (isset($_GET['id'])){
  $query  =  query("SELECT *FROM categories where cat_id=$_GET[id]");
  $data = $query->fetch_object();
  }
  $query  =  query("SELECT *FROM categories where parent=0");
$categories = $query->fetch_all(MYSQLI_ASSOC);
?>
<div class="col-md-12">

<div class="row">
<h1 class="page-header">
<?php if ($data->cat_id ==""){  echo "Publish";} else {echo "Edit";}?> category

</h1>
</div>        
<form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Categoy Title </label>
        <input type="text" name="cat_title" value="<?= $data->cat_title ;?>" class="form-control">
       
    </div>

    <div class="form-group">
         <label for="product-title">Category</label>

          
        <select name="parent" id="" class="form-control">

            <option value="0">Select parent category</option>
            <?php foreach ($categories as $key => $value):?> 
              <option value="<?= $value['cat_id']; ?>"  <?php if ( $value['cat_id'] == $data->parent){echo "selected";}?> ><?= $value['cat_title']; ?></option>

              <?php endforeach; ?>
        </select>


</div>
    



   

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     
     <div class="form-group">

        <input type="submit" name="publish" class="btn btn-primary btn-lg" value="<?php if ($data->cat_id ==""){  echo "Publish";} else {echo "Edit";}?>">
    </div>


     <!-- Product Categories-->

  





    <!-- Product Brands-->


   

<!-- Product Tags -->


   



</aside><!--SIDEBAR-->


    
</form>


           