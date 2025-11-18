<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_login();
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Reservation</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3>Add Reservation</h3>

  <form method="POST" action="save.php">

    <div class="mb-3">
      <label class="form-label">Select Room</label>
      <select name="room_id" class="form-control" required>
        <option value="">Select a room</option>
        <?php
       
        $rooms = $pdo->query("SELECT id, room_number FROM rooms WHERE status='available'")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rooms as $room) {
            echo "<option value=\"{$room['id']}\">Room {$room['room_number']}</option>";
        }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Guest Name</label>
      <input type="text" name="guest_name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Guest Contact</label>
      <input type="text" name="guest_contact" class="form-control">
    </div>

    <div class="mb-3">
      <label class="form-label">Check-in Date</label>
      <input type="date" name="check_in" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Check-out Date</label>
      <input type="date" name="check_out" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Notes</label>
      <textarea name="notes" class="form-control"></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Total Cost</label>
      <input type="number" name="total_cost" step="0.01" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Save Reservation</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>

  </form>
</div>

</body>
</html>
