<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$err = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = trim($_POST['room_number'] ?? '');
    $room_type = trim($_POST['room_type'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!$room_number || !$room_type || !$price) {
        $err = 'Room number, type, and price are required.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO rooms (room_number, room_type, price, description) VALUES (?, ?, ?, ?)');
        if ($stmt->execute([$room_number, $room_type, $price, $description])) {
            $success = 'Room added successfully!';
        } else {
            $err = 'Failed to add room.';
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Room - Hotel System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Add Room</h2>
    <?php if ($err): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($err); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
        <div class="mb-3">
            <label>Room Number</label>
            <input name="room_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Room Type</label>
            <input name="room_type" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input name="price" type="number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">Add Room</button>
        <a href="dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
