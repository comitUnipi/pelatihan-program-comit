<?php
require_once 'config.php';

$username = 'admin';
$password = 'admin123';
$password_value = password_hash($password, PASSWORD_DEFAULT);

$stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt_check->bind_param("s", $username);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "User admin '{$username}' sudah ada. Tidak ada user baru yang dimasukkan.<br>";
} else {
    $stmt_insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt_insert->bind_param("ss", $username, $password_value);

    if ($stmt_insert->execute()) {
        echo "User admin '{$username}' berhasil dibuat dengan password '{$password}'.<br>";
        echo "Harap ingat password ini. Anda sekarang bisa menghapus file 'seed_admin.php' ini.<br>";
    } else {
        echo "Error saat membuat user admin: " . $stmt_insert->error . "<br>";
    }
    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
?>
