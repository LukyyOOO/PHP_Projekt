<?php
session_start();
include 'db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];
    $query = "SELECT * FROM users WHERE remember_token = '$token'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_or_nick = $_POST['email_or_nick'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $query = "SELECT * FROM users WHERE email = '$email_or_nick' OR username = '$email_or_nick'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];

            if ($remember) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_me', $token, time() + (86400 * 30), "/");
                $update_query = "UPDATE users SET remember_token = '$token' WHERE id = " . $user['id'];
                mysqli_query($conn, $update_query);
            }

            header("Location: index.php");
            exit();
        } else {
            echo "Błędne hasło!";
        }
    } else {
        echo "Użytkownik nie istnieje!";
    }
}
?>

<form method="POST">
    <input type="text" name="email_or_nick" placeholder="Email lub nick" required>
    <input type="password" name="password" placeholder="Hasło" required>
    <label><input type="checkbox" name="remember"> Zapamiętaj mnie</label>
    <button type="submit">Zaloguj</button>
</form>