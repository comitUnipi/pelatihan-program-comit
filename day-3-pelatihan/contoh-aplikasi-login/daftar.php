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

<h1>Pendaftaran</h1>
<form method="POST" action="">
	<input type="text" name="username" placeholder="Username" required>
	<br><br>
	<input type="password" name="password" placeholder="Password" required>
	<br><br>
	<button type="submit" name="daftar">Daftar Sekarang</button>
</form>