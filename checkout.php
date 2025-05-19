<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id) {
        $update_query = "UPDATE products SET quantity = quantity - 1 WHERE id = $product_id";
        mysqli_query($conn, $update_query);
    }
    unset($_SESSION['cart']);
    echo "<h1>Dziękujemy za zakupy!</h1>";
} else {
    echo "<p>Twój koszyk jest pusty.</p>";
}
?>