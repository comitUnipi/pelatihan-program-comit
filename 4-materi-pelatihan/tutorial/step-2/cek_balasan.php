<?php
require_once 'config.php';

$saran = null;
$error = '';

if (isset($_GET['kode'])) {
    $kode = trim($_GET['kode']);
    if (!empty($kode)) {
        $stmt = $conn->prepare("SELECT * FROM saran WHERE kode_unik = ?");
        $stmt->bind_param("s", $kode);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $saran = $result->fetch_assoc();
        } else {
            $error = "Kode tidak ditemukan. Pastikan Anda memasukkan kode yang benar.";
        }
        $stmt->close();
    } else {
        $error = "Kode tidak boleh kosong.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Balasan</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/" class="nav-brand">Kotak Saran</a>
            <div>
                <a href="cek_balasan.php" class="nav-link active">Cek Balasan</a>
                <a href="login.php" class="nav-link">Admin Login</a>
            </div>
        </div>
    </nav>

    <main class="main-container">
        <div class="content-wrapper">
            <div class="content-header">
                <h1>Cek Status & Balasan</h1>
                <p>Masukkan kode unik yang Anda dapatkan setelah mengirim pesan.</p>
            </div>

            <form method="GET" action="cek_balasan.php">
                <div class="form-group">
                    <label for="kode">Kode Unik Anda</label>
                    <input type="text" id="kode" name="kode" value="<?php echo htmlspecialchars($_GET['kode'] ?? ''); ?>" required>
                </div>
                <button type="submit">Cari Pesan</button>
            </form>

            <?php if ($error): ?>
                <p class="error" style="text-align:center; margin-top: 1.5rem;"><?php echo $error; ?></p>
            <?php endif; ?>

            <?php if ($saran): ?>
                <div class="balasan-wrapper" style="margin-top: 2rem;">
                    <div class="saran-item">
                        <p><?php echo htmlspecialchars($saran['pesan']); ?></p>
                        <div class="meta">
                            <span>Kategori: <?php echo htmlspecialchars($saran['kategori']); ?></span>
                            <span>Diterima: <?php echo date('d M Y', strtotime($saran['waktu_dibuat'])); ?></span>
                        </div>
                    </div>
                    <div class="balasan-content">
                        <h4>Balasan Admin:</h4>
                        <?php if (!empty($saran['balasan'])): ?>
                            <p><?php echo nl2br(htmlspecialchars($saran['balasan'])); ?></p>
                        <?php else: ?>
                            <p class="no-reply">Belum ada balasan dari admin.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </main>

</body>
</html>
