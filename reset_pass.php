<?php
require 'includes/db.php';

$newPasswordHash = password_hash('admin123', PASSWORD_DEFAULT);

$pdo->query("UPDATE users SET password_hash='$newPasswordHash' WHERE username='admin'");

echo "Password for admin has been reset to admin123";
?>
