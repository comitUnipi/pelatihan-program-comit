
<?php
include "koneksi.php";

if (isset($_POST['daftar'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$query = "INSERT INTO users (username, password) VALUE ('$username', '$password')";

	if (mysqli_query($koneksi, $query)) {
		echo "pendaftaran telah berhasil! <a href='login.php'>login disini</a>";
	} else {
		echo "terjadi kesalahan: " . mysqli_error($koneksi);
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Pendaftaran</h1>
        <form method="POST" action="">
            <div>
                <label>Username</label>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="daftar">Daftar Sekarang</button>
        </form>
    </div>
</body>
</html>
