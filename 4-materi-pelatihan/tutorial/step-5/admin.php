<?php
session_start();
require_once 'config.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result_user = $stmt->get_result();

    if ($result_user->num_rows === 1) {
        $user = $result_user->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: admin.php");
            exit;
        } else {
            header("Location: login.php?error=Username atau password salah");
            exit;
        }
    } else {
        header("Location: login.php?error=Username atau password salah");
        exit;
    }
    $stmt->close();
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$results_per_page = 5;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $results_per_page;

$search_query = $_GET['search'] ?? '';
$category_filter = $_GET['kategori'] ?? '';

$sql_base = "FROM saran";
$where_clauses = [];
$params = [];
$types = '';

if (!empty($search_query)) {
    $where_clauses[] = "pesan LIKE ?";
    $params[] = "%{$search_query}%";
    $types .= 's';
}

if (!empty($category_filter)) {
    $where_clauses[] = "kategori = ?";
    $params[] = $category_filter;
    $types .= 's';
}

$sql_where = '';
if (!empty($where_clauses)) {
    $sql_where = " WHERE " . implode(' AND ', $where_clauses);
}

$total_result_sql = "SELECT COUNT(*) as total " . $sql_base . $sql_where;
$stmt_total = $conn->prepare($total_result_sql);
if (!empty($params)) {
    $stmt_total->bind_param($types, ...$params);
}
$stmt_total->execute();
$total_results = $stmt_total->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_results / $results_per_page);

$data_sql = "SELECT * " . $sql_base . $sql_where . " ORDER BY waktu_dibuat DESC LIMIT ? OFFSET ?";
$types .= 'ii';
$params[] = $results_per_page;
$params[] = $offset;

$stmt_data = $conn->prepare($data_sql);
$stmt_data->bind_param($types, ...$params);
$stmt_data->execute();
$result = $stmt_data->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Daftar Saran</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/" class="nav-brand">Kotak Saran</a>
            <div>
                <a href="admin.php" class="nav-link active">Daftar Saran</a>
                <a href="manage_admins.php" class="nav-link">Manajemen Admin</a>
                <a href="logout.php" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>

    <main class="main-container">
        <div class="content-wrapper" style="max-width: 900px;">
            <div class="content-header">
                <h1>Daftar Saran Masuk</h1>
            </div>

            <form method="GET" action="admin.php" class="filter-form">
                <input type="text" name="search" placeholder="Cari pesan..." value="<?php echo htmlspecialchars($search_query); ?>">
                <select name="kategori" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <option value="Umum" <?php echo ($category_filter == 'Umum') ? 'selected' : ''; ?>>Umum</option>
                    <option value="Kepengurusan" <?php echo ($category_filter == 'Kepengurusan') ? 'selected' : ''; ?>>Kepengurusan</option>
                    <option value="Akademik" <?php echo ($category_filter == 'Akademik') ? 'selected' : ''; ?>>Akademik</option>
                    <option value="Pelatihan" <?php echo ($category_filter == 'Pelatihan') ? 'selected' : ''; ?>>Pelatihan</option>
                </select>
            </form>

            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="saran-item">
                        <p><?php echo htmlspecialchars($row['pesan']); ?></p>
                        <div class="meta">
                            <span>Kategori: <b><?php echo htmlspecialchars($row['kategori']); ?></b></span>
                            <span class="status-badge status-<?php echo str_replace(' ', '-', $row['status']); ?>"><?php echo $row['status']; ?></span>
                        </div>
                        <div class="meta" style="margin-top: 8px;">
                            <span>Kode: <code><?php echo htmlspecialchars($row['kode_unik']); ?></code></span>
                            <span>Diterima: <?php echo date('d M Y, H:i', strtotime($row['waktu_dibuat'])); ?></span>
                        </div>

                        <div class="reply-box">
                            <?php if (!empty($row['balasan'])): ?>
                                <strong>Balasan Anda:</strong>
                                <p style="background-color: #f0f0f0; padding: 10px; border-radius: 5px;"><?php echo nl2br(htmlspecialchars($row['balasan'])); ?></p>
                            <?php else: ?>
                                <form action="proses_balasan.php" method="POST">
                                    <input type="hidden" name="saran_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="current_page" value="<?php echo $current_page; ?>">
                                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search_query); ?>">
                                    <input type="hidden" name="kategori" value="<?php echo htmlspecialchars($category_filter); ?>">
                                    <textarea name="balasan" placeholder="Tulis balasan..." required></textarea>
                                    <button type="submit">Kirim Balasan</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>

                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search_query); ?>&kategori=<?php echo urlencode($category_filter); ?>" class="<?php echo ($i == $current_page) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>

            <?php else: ?>
                <p style="text-align: center; margin-top: 2rem;">Tidak ada pesan yang cocok dengan kriteria Anda.</p>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
<?php
$conn->close();
?>
