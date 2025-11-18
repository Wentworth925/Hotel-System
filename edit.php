<?php
require '../includes/auth.php';
require '../includes/db.php';
require_login();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: list.php');
    exit;
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM reservations WHERE id = ?");
$stmt->execute([$id]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    header('Location: list.php');
    exit;
}

$rooms = $pdo->query("SELECT id, room_number FROM rooms WHERE status='available' OR id={$reservation['room_id']}")->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit Reservation</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<h3>Edit Reservation</h3>

<form method="POST" action="save_edit.php">
    <input type="hidden" name="id" value="<?php echo $reservation['id']; ?>">

    <div class="mb-3">
        <label class="form-label">Room</label>
        <select name="room_id" class="form-control" required>
            <option value="">Select a room</option>
            <?php foreach ($rooms as $room): ?>
                <option value="<?php echo $room['id']; ?>" <?php if($room['id']==$reservation['room_id']) echo 'selected'; ?>>
                    Room <?php echo $room['room_number']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Guest Name</label>
        <input type="text" name="guest_name" class="form-control" value="<?php echo htmlspecialchars($reservation['guest_name']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Guest Contact</label>
        <input type="text" name="guest_contact" class="form-control" value="<?php echo htmlspecialchars($reservation['guest_contact']); ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Check-in Date</label>
        <input type="date" name="check_in" class="form-control" value="<?php echo $reservation['check_in']; ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Check-out Date</label>
        <input type="date" name="check_out" class="form-control" value="<?php echo $reservation['check_out']; ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control"><?php echo htmlspecialchars($reservation['notes']); ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Total Cost</label>
        <input type="number" step="0.01" name="total_cost" class="form-control" value="<?php echo $reservation['total_cost']; ?>" required>
    </div>

    <button type="submit" class="btn btn-success">Save Changes</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</body>
</html>
