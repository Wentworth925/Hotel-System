<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_login();
$res = $pdo->query('SELECT r.*, rm.room_number FROM reservations r JOIN rooms rm ON rm.id = r.room_id ORDER BY r.created_at DESC')->fetchAll();
?>
<!doctype html><html><head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Reservations</title></head><body class="p-4">
<div class="container">
  <h3>Reservations <a class="btn btn-sm btn-primary" href="add.php">Add Reservation</a></h3>
  <table class="table table-striped mt-3">
    <thead><tr><th>Guest</th><th>Room</th><th>Check-in</th><th>Check-out</th><th>Total</th><th>Action</th></tr></thead>
    <tbody>
    <?php foreach($res as $r): ?>
      <tr>
        <td><?php echo htmlspecialchars($r['guest_name']); ?></td>
        <td><?php echo htmlspecialchars($r['room_number']); ?></td>
        <td><?php echo $r['check_in']; ?></td>
        <td><?php echo $r['check_out']; ?></td>
        <td><?php echo number_format($r['total_cost'],2); ?></td>
        <td>
          <a class="btn btn-sm btn-warning" href="edit.php?id=<?php echo $r['id']; ?>">Edit</a>
          <a class="btn btn-sm btn-danger" href="delete.php?id=<?php echo $r['id']; ?>" onclick="return confirm('Cancel?')">Cancel</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body></html>
