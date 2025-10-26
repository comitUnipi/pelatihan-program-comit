<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/" class="nav-brand">Kotak Saran</a>
        </div>
    </nav>

    <main class="main-container">
        <div class="content-wrapper">
            <div class="content-header">
                <h1>Login Admin</h1>
            </div>

            <form action="admin.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <?php
                if (isset($_GET['error'])) {
                    echo '<p class="error" style="text-align:center; margin-top: 1.5rem;">' . htmlspecialchars($_GET['error']) . '</p>';
                }
            ?>
        </div>
    </main>

</body>
</html>
