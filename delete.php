<?php
session_start(); 

require 'includes/auth.php';
require 'includes/db.php';
require_login();

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No room ID provided.";
    header('Location: dashboard.php');
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
if ($stmt->execute([$id])) {
    $_SESSION['success'] = "Room deleted successfully!";
} else {
    $_SESSION['error'] = "Failed to delete room.";
}
header('Location: dashboard.php');
exit;
