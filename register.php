<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Nazwa użytkownika jest już zajęta!";
    } else {
        $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($conn, $insert_query)) {
            echo "Rejestracja udana! Możesz się zalogować.";
        } else {
            echo "Błąd rejestracji!";
        }
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Nazwa użytkownika" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Hasło" required>
    <button type="submit">Zarejestruj</button>
</form>