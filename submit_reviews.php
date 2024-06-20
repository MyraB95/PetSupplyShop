<?php
require_once("../resources/config.php");

//session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
        $review = escape_string($_POST['review']);
        $product_id = escape_string($_POST['product_id']);
        $user_id = $_SESSION['user_id']; // Assuming you store user ID in session

        // Insert the review into the database
        $query = query("INSERT INTO reviews (product_id, user_id, review_text) VALUES ('$product_id', '$user_id', '$review')");
        confirm($query);

        // Redirect back to the product page
        header("Location: item.php?id=" . $product_id);
        exit;
    } else {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit;
    }
}
