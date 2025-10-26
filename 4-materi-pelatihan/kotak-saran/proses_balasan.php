<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $saran_id = $_POST['saran_id'] ?? 0;
    $balasan = trim($_POST['balasan'] ?? '');
    $current_page = $_POST['current_page'] ?? 1;

    if (!empty($saran_id) && !empty($balasan)) {
        $stmt = $conn->prepare("UPDATE saran SET balasan = ?, status = 'Sudah Dibalas' WHERE id = ?");
        $stmt->bind_param("si", $balasan, $saran_id);
        $stmt->execute();
        $stmt->close();
    }

    $query_params = http_build_query([
        'page' => $current_page,
        'search' => $_POST['search'] ?? null,
        'kategori' => $_POST['kategori'] ?? null
    ]);
    header("Location: admin.php?" . $query_params);
    exit;
}

$conn->close();
?>
