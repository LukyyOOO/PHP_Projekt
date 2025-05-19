<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Sieciaczek</title>
</head>
<body>
    <header>
        <img src="images/logo.png" alt="Logo sklepu">
    </header>

    <main>
        <h1>Nasze produkty</h1>
        <div class="products">
            <?php
            $query = "SELECT * FROM products LIMIT 3";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='product'>";
                echo "<h3>" . $row['name'] . "</h3>";
                echo "<p>Cena: " . $row['price'] . " zł</p>";
                echo "<a href='cart.php?add=" . $row['id'] . "'>Dodaj do koszyka</a>";
                echo "</div>";
            }
            ?>
        </div>
    </main>
</body>
</html>