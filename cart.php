<?php
session_start();
include 'db.php';

if (isset($_GET['add'])) {
    $product_id = $_GET['add'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $product_id;
    header("Location: cart.php");
}

if (isset($_SESSION['cart'])) {
    echo "<h2>Twój koszyk</h2>";
    foreach ($_SESSION['cart'] as $product_id) {
        $query = "SELECT * FROM products WHERE id = $product_id";
        $result = mysqli_query($conn, $query);
        $product = mysqli_fetch_assoc($result);
        echo "<p>" . $product['name'] . " - " . $product['price'] . " zł</p>";
    }
    echo "<a href='checkout.php'>Przejdź do płatności</a>";
} else {
    echo "<p>Koszyk jest pusty.</p>";
}
?>