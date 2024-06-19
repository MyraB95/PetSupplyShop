<?php require_once("../resources/config.php");
require_once("../resources/functions.php");
?>

<?php
if (isset($_POST)) {

   if (!isset($_SESSION['cart'])){
        $_SESSION['cart'] = []; 
    }
        $_SESSION['cart'][$_POST['productId']]['productId'] = $_POST['productId']; 
        $_SESSION['cart'][$_POST['productId']]['title'] = $_POST['title']; 
        $_SESSION['cart'][$_POST['productId']]['price'] = $_POST['price']; 
        if (isset($_SESSION['cart'][$_POST['productId']]['quantity'])){
            $_SESSION['cart'][$_POST['productId']]['quantity']++; 
        }
        else{
            $_SESSION['cart'][$_POST['productId']]['quantity'] = 1; 

        }
        log_interaction($_POST['productId'],"add cart",$connection); 

        echo 'add to cart'; 


   
} else {
    set_message("");
}

?>