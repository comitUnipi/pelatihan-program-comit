<?php
$host = "127.0.0.1";
$username = "root";
$password = "develovers";
$dbname = "db_toko";

$koneksi = new mysqli($host, $username, $password, $dbname);

if ($koneksi->connect_error) {
	die("koneksi gagal: " . $koneksi->connect_error);
}
