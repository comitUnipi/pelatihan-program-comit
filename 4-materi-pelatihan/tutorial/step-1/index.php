<?php
session_start();
require_once 'config.php';

$message = '';
$message_type = '';
$kode_unik_display = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pesan = trim($_POST['pesan'] ?? '');
    $kategori = trim($_POST['kategori'] ?? 'Umum');

    if (!empty($pesan)) {
        $kode_unik = uniqid('saran-');

        $stmt = $conn->prepare("INSERT INTO saran (pesan, kategori, kode_unik) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $pesan, $kategori, $kode_unik);

        if ($stmt->execute()) {
            $message = 'Pesan Anda telah berhasil dikirim. Simpan kode ini untuk melihat balasan:';
            $message_type = 'success';
            $kode_unik_display = $kode_unik;
        } else {
            $message = 'Gagal menyimpan pesan ke database.';
            $message_type = 'error';
        }
        $stmt->close();
    } else {
        $message = 'Pesan tidak boleh kosong.';
        $message_type = 'error';
    }
    $conn->close();
}

if (isset($_SESSION['form_message'])) {
    $message = $_SESSION['form_message'];
    $message_type = $_SESSION['form_message_type'];
    $kode_unik_display = $_SESSION['form_kode_unik'] ?? '';
    unset($_SESSION['form_message']);
    unset($_SESSION['form_message_type']);
    unset($_SESSION['form_kode_unik']);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kotak Saran, Kritik dan Aspirasi</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/kotak-saran" class="nav-brand">Kotak Saran</a>
            <div>
                <a href="cek_balasan.php" class="nav-link">Cek Balasan</a>
                <a href="login.php" class="nav-link">Admin Login</a>
            </div>
        </div>
    </nav>

    <main class="main-container">
        <div class="content-wrapper">
            <div class="content-header">
                <h1>Sampaikan Saran, Kritik dan Aspirasi Anda</h1>
                <p>Semua pesan yang dikirim bersifat anonim.</p>
            </div>

            <form action="index.php" method="POST">
                <div class="form-group">
                    <label for="kategori">Kategori Pesan</label>
                    <select id="kategori" name="kategori" required>
                        <option value="Umum">Umum</option>
                        <option value="Kepengurusan">Kepengurusan</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Pelatihan">Pelatihan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pesan">Pesan Anda</label>
                    <textarea id="pesan" name="pesan" rows="8" required placeholder="Tuliskan saran, kritik, atau aspirasi Anda di sini..."></textarea>
                </div>
                <button type="submit">Kirim Pesan</button>
            </form>

            <?php if ($message): ?>
                <div class="response-message <?php echo $message_type; ?>">
                    <p><?php echo $message; ?></p>
                    <?php if ($kode_unik_display): ?>
                        <div class="kode-unik-box"><strong><?php echo $kode_unik_display; ?></strong></div>
                        <p class="info-text">Gunakan kode di atas untuk memeriksa balasan dari admin di halaman Cek Balasan.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
