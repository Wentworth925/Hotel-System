<?php
require 'includes/auth.php';
require 'includes/db.php';
require_login();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: rooms_list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->execute([$id]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$room) {
    header('Location: rooms_list.php');
    exit;
}

$err = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = trim($_POST['room_number']);
    $room_type = trim($_POST['room_type']);
    $price = trim($_POST['price']);
    $status = trim($_POST['status']);
    $description = trim($_POST['description']);

    if (!$room_number || !$room_type || !$price || !$status) {
        $err = "All fields except description are required.";
    } else {
        $stmt = $pdo->prepare("UPDATE rooms SET room_number=?, room_type=?, price=?, status=?, description=? WHERE id=?");
        if ($stmt->execute([$room_number, $room_type, $price, $status, $description, $id])) {
            $success = "Room updated successfully!";
            $stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
            $stmt->execute([$id]);
            $room = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $err = "Failed to update room.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit Room</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Edit Room #<?php echo $room['id']; ?></h2>

    <?php if ($err): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($err); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Room Number</label>
            <input name="room_number" class="form-control" value="<?php echo htmlspecialchars($room['room_number']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Room Type</label>
            <input name="room_type" class="form-control" value="<?php echo htmlspecialchars($room['room_type']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input name="price" type="number" class="form-control" value="<?php echo htmlspecialchars($room['price']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="available" <?php if($room['status']=='available') echo 'selected'; ?>>Available</option>
                <option value="booked" <?php if($room['status']=='booked') echo 'selected'; ?>>Booked</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"><?php echo htmlspecialchars($room['description']); ?></textarea>
        </div>
        <button class="btn btn-primary">Save Changes</button>
        <a href="rooms_list.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
