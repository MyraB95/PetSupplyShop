 <?php
    $url ="index.php"; 
    $chart_title = "Products liked"; 
    $chart_x = 'product';
    $chart_y = "liked";
    $page = 0;
    $period='week';
    $filtre_day = 'cart.purchase_at'; 
    if (isset($_GET['period'])){
        $period = $_GET['period'];
    }

    if (isset($_GET['sales'])) {
        $url .='?sales'; 
       
        $chart_title = "Sales"; 
        $chart_x = 'by date';
        $chart_y = "quantity";
    }else{
        $url .='?liked'; 
        $filtre_day = 'likes.liked_at'; 

    }
    $between = ""; 

    $limit = 10;
    $now = new DateTime('now');
     
 
    
    $query_cmd = "";
    $end = $now->modify('+1 day')->format('Y/m/d');

   if ($period=="month"){
        $interval = new DateInterval('P30D');
        $now->sub($interval);
        $begin = $now->format('Y/m/d');
        $between = "where   $filtre_day >=  '$begin' AND  $filtre_day <= '$end'";

        //$between = " where  cart.purchase_at >= '$begin' AND '$end'";
    }
    elseif ($period=="year"){
        $interval = new DateInterval('P1Y');
         $now->sub($interval);
         $begin = $now->format('Y/m/d');
         $between = "where $filtre_day >=  '$begin' AND  $filtre_day <= '$end'";

    }
    else{
        $interval = new DateInterval('P7D');
        $now->sub($interval);
        $begin = $now->format('Y/m/d');
        $between = "where   $filtre_day >=  '$begin' AND  $filtre_day <= '$end'";
    }

    $likes = ("SELECT 
                products.product_id,
                products.product_title as x,
                count(likes.product_id) as  y,
                likes.liked_at as day
                from products
                LEFT JOIN product_likes as likes ON likes.product_id = products.product_id
                $between
                GROUP BY products.product_id  
                ORDER BY products.product_title
                LIMIT " . $page * $limit . ",$limit; 
                ");


    $salesByCart = ("
                SELECT sum(cart.quantity) as y , cart.cart_id as cart, 
                
                DATE_FORMAT(cart.purchase_at,'%Y%/%m/%d') as x, 
                cart.purchase_at as day
                FROM user_cart as cart 
             
                LEFT JOIN products ON products.product_id = cart.product_id LEFT JOIN users ON users.user_id = cart.user_id 
                $between
                GROUP BY DATE_FORMAT(cart.purchase_at, '%Y%m%d')
                ORDER BY cart.purchase_at ASC;
                ");

    


    if (isset($_GET['page'])) {
        if (!empty($_GET['page'])) {
            $page = $_GET['page'];
        }
    }

   
    if (isset($_GET['sales'])) {
      
        $query_cmd = $salesByCart;
    }else{
        $query_cmd = $likes; //
    }
  // die($query_cmd);  
    $query = query($query_cmd);

    $chart = $query->fetch_all(MYSQLI_ASSOC);
   
    ?>

 <div class="col-md-12">
     <div class="row">
         <h1 class="page-header">
             <?= $chart_title ?>

         </h1>
     </div>
<div class="row">
<div class="col-md-12">
<a href="<?=$url?>">
<button class="btn <?php if ($period =="week") {echo 'btn-primary';}?>">
    Last week
</button> 
</a>
&nbsp;
<a href="<?=$url.'&period=month'?>">
<button class="btn  <?php if ($period =="month") {echo 'btn-primary';}?>">
Last month </button>  
</a>
<?php if ( $chart_y == "liked") : ?>
&nbsp;
<a href="<?=$url.'&period=year'?>">
<button class="btn <?php if ($period =="year") {echo 'btn-primary';}?>">
    Last year </button>
</a>
<?php endif;?>
</div>

</div>
     <div class="row">
         <?php


            ?>
         <table class="highchart table table-striped" data-graph-container-before="1" data-graph-type="<?php if ( ($period=="year" || $period=="month") && $chart_y != "liked" ) { echo "line";}else{echo "column";}?>">
             <thead>
                 <tr>
                     <th><?= $chart_x; ?></th>
                     <th><?= $chart_y; ?></th>

                 </tr>
             </thead>
             <tbody>
                 <?php foreach ($chart as $key => $line) : ?>
                     <tr>
                         <td><?= $line['x']; ?></td>
                         <td><?= $line['y']; ?></td>

                     </tr>
                 <?php endforeach; ?>
             </tbody>
         </table>
     </div>

     <script>
         $(document).ready(function() {
             $('table.highchart').highchartTable();
         });
         //jQuery(document).ready(function() {
         // jQuery('table.highchart').highchartTable();
         //});
     </script>