<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'add' || $action == 'edit') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $user_id = $_POST['user_id'] ?? null;

            if (empty($username) || empty($password)) {
                $error = "Username dan password tidak boleh kosong.";
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);

                if ($action == 'add') {
                    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                    $stmt->bind_param("ss", $username, $password);
                    if ($stmt->execute()) {
                        $message = "Admin baru berhasil ditambahkan.";
                    } else {
                        $error = "Gagal menambahkan admin: " . $conn->error;
                    }
                } elseif ($action == 'edit') {
                    if ($user_id) {
                        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
                        $stmt->bind_param("ssi", $username, $password, $user_id);
                        if ($stmt->execute()) {
                            $message = "Admin berhasil diperbarui.";
                        } else {
                            $error = "Gagal memperbarui admin: " . $conn->error;
                        }
                    } else {
                        $error = "ID Admin tidak ditemukan untuk pembaruan.";
                    }
                }
                $stmt->close();
            }
        } elseif ($action == 'delete') {
            $user_id = $_POST['user_id'] ?? null;
            if ($user_id && $user_id != $_SESSION['user_id']) {
                $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                if ($stmt->execute()) {
                    $message = "Admin berhasil dihapus.";
                } else {
                    $error = "Gagal menghapus admin: " . $conn->error;
                }
                $stmt->close();
            } else {
                $error = "Tidak dapat menghapus admin ini atau admin tidak ditemukan.";
            }
        }
    }
}

$users_result = $conn->query("SELECT id, username, created_at FROM users ORDER BY created_at DESC");

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Admin</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/" class="nav-brand">Kotak Saran</a>
            <div>
                <a href="admin.php" class="nav-link">Daftar Saran</a>
                <a href="manage_admins.php" class="nav-link active">Manajemen Admin</a>
                <a href="logout.php" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>

    <main class="main-container">
        <div class="content-wrapper" style="max-width: 900px;">
            <div class="content-header">
                <h1>Manajemen Admin</h1>
            </div>

            <?php if ($message): ?>
                <p class="success" style="text-align:center; margin-bottom: 1.5rem;"><?php echo $message; ?></p>
            <?php endif; ?>
            <?php if ($error): ?>
                <p class="error" style="text-align:center; margin-bottom: 1.5rem;"><?php echo $error; ?></p>
            <?php endif; ?>

            <h2>Tambah Admin Baru</h2>
            <form action="manage_admins.php" method="POST" class="admin-form">
                <input type="hidden" name="action" value="add">
                <div class="form-group">
                    <label for="new_username">Username</label>
                    <input type="text" id="new_username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Password</label>
                    <input type="password" id="new_password" name="password" required>
                </div>
                <button type="submit">Tambah Admin</button>
            </form>

            <h2 style="margin-top: 3rem;">Daftar Admin</h2>
            <?php if ($users_result && $users_result->num_rows > 0): ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Dibuat Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($user = $users_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo date('d M Y H:i', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <button class="btn-edit" onclick="showEditForm(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['username']); ?>')">Edit</button>
                                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                        <form action="manage_admins.php" method="POST" style="display:inline-block; margin-left: 5px;" onsubmit="return confirm('Yakin ingin menghapus admin ini?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn-delete">Hapus</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <p style="text-align: center;">Belum ada admin yang terdaftar.</p>
            <?php endif; ?>

            <div id="editAdminModal" class="modal" style="display:none;">
                <div class="modal-content">
                    <span class="close-button" onclick="hideEditForm()">&times;</span>
                    <h2>Edit Admin</h2>
                    <form action="manage_admins.php" method="POST" class="admin-form">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" id="edit_user_id" name="user_id">
                        <div class="form-group">
                            <label for="edit_username">Username</label>
                            <input type="text" id="edit_username" name="username" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_password">Password Baru</label>
                            <input type="password" id="edit_password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah" minlength="6">
                        </div>
                        <button type="submit">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <script>
        function showEditForm(id, username) {
            document.getElementById('edit_user_id').value = id;
            document.getElementById('edit_username').value = username;
            document.getElementById('editAdminModal').style.display = 'block';
        }

        function hideEditForm() {
            document.getElementById('editAdminModal').style.display = 'none';
            document.getElementById('edit_password').value = '';
        }

        window.onclick = function(event) {
            let modal = document.getElementById('editAdminModal');
            if (event.target == modal) {
                modal.style.display = 'none';
                document.getElementById('edit_password').value = '';
            }
        }
    </script>
</body>
</html>
