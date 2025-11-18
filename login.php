<?php
session_start();
require 'includes/db.php';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        $err = 'Provide username & password';
    } else {
        $stmt = $pdo->prepare('SELECT id, username, password_hash, role FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
                header('Location: dashboard.php');
                exit;
            } else {
                $err = 'Incorrect password';
            }
        } else {
            $err = 'Username not found';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login - Hotel System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container vh-100 d-flex align-items-center justify-content-center">
  <div class="card shadow-sm" style="width:380px;">
    <div class="card-body p-4">
      <h4 class="mb-3 text-center">Hotel System - Login</h4>
      <?php if ($err): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($err); ?></div>
      <?php endif; ?>
      <form method="post" novalidate>
        <div class="mb-3">
          <input name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3">
          <input name="password" type="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="d-grid">
          <button class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
