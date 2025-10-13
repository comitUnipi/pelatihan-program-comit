<?php
include "koneksi.php";
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $_SESSION['username'] = $user['username'];
        header("Location: welcome.php");
    } else {
        echo "Username atau password salah!";
    }
}

?>

<h2>Login</h2>
<form method="POST" action="">
    <input type="text" name="username" placeholder="Username" required>
    <br><br>
    <input type="password" name="password" placeholder="Password" required>
    <br><br>
    <button type="submit" name="login">Login</button>
</form>

<p>Belum punya akun? <a href="daftar.php">Daftar di sini</a></p>