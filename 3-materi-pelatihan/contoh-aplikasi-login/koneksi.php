<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "db_toko";

$koneksi = new mysqli($host, $username, $password, $dbname);

if ($koneksi->connect_error) {
	die("koneksi gagal: " . $koneksi->connect_error);
}
