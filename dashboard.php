<?php
session_start();
require 'includes/auth.php';
require 'includes/db.php';
require_login();

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

$totalRooms = $pdo->query('SELECT COUNT(*) FROM rooms')->fetchColumn();
$available = $pdo->query("SELECT COUNT(*) FROM rooms WHERE status='available'")->fetchColumn();
$booked = $pdo->query('SELECT COUNT(*) FROM reservations')->fetchColumn();

$rooms = $pdo->query("SELECT * FROM rooms ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Hotel Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
  body { background-color: #f4f6f9; }
  .card { border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s; }
  .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
  .summary-card { color: #fff; position: relative; overflow: hidden; }
  .summary-card i { position: absolute; top: 15px; right: 15px; font-size: 3rem; opacity: 0.2; }
  .summary-card.total { background: linear-gradient(135deg, #667eea, #764ba2); }
  .summary-card.available { background: linear-gradient(135deg, #43cea2, #185a9d); }
  .summary-card.booked { background: linear-gradient(135deg, #ff758c, #ff7eb3); }
  .table-hover tbody tr:hover { background-color: #e9ecef; }
  .navbar { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
  .badge-status { font-size: 0.9rem; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 sticky-top">
  <a class="navbar-brand" href="#"><i class="bi bi-building"></i> Hotel System</a>
  <div class="ms-auto">
      <a href="export_csv.php" class="btn btn-success btn-sm me-2"><i class="bi bi-file-earmark-spreadsheet"></i> Export CSV</a>
      <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>
</nav>

<div class="container mt-5">

  <!-- Flash Messages -->
  <?php if ($success): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($success); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  <?php endif; ?>
  <?php if ($error): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  <?php endif; ?>

  <!-- Summary Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card summary-card total p-4 text-center">
        <i class="bi bi-building"></i>
        <h6>Total Rooms</h6>
        <h2><?php echo $totalRooms; ?></h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card summary-card available p-4 text-center">
        <i class="bi bi-door-open"></i>
        <h6>Available</h6>
        <h2><?php echo $available; ?></h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card summary-card booked p-4 text-center">
        <i class="bi bi-person-check"></i>
        <h6>Booked</h6>
        <h2><?php echo $booked; ?></h2>
      </div>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="mb-4">
    <a class="btn btn-success me-2 mb-2" href="add_room.php"><i class="bi bi-plus-lg"></i> Add Room</a>
    <a class="btn btn-secondary me-2 mb-2" href="reservations/list.php"><i class="bi bi-card-checklist"></i> Manage Reservations</a>
    <a class="btn btn-secondary me-2 mb-2" href="reservations/add.php"><i class="bi bi-plus-lg"></i> Add Reservation</a>
  </div>

  <!-- Rooms Table -->
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0"><i class="bi bi-house-door"></i> Rooms Overview</h5>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Room Number</th>
              <th>Type</th>
              <th>Status</th>
              <th>Price</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($rooms as $room): ?>
            <tr>
              <td><?php echo $room['id']; ?></td>
              <td><?php echo htmlspecialchars($room['room_number']); ?></td>
              <td><?php echo htmlspecialchars($room['room_type']); ?></td>
              <td>
                <?php if ($room['status'] == 'available'): ?>
                  <span class="badge bg-success badge-status"><?php echo htmlspecialchars($room['status']); ?></span>
                <?php else: ?>
                  <span class="badge bg-danger badge-status"><?php echo htmlspecialchars($room['status']); ?></span>
                <?php endif; ?>
              </td>
              <td><span class="text-primary fw-bold">$<?php echo htmlspecialchars($room['price']); ?></span></td>
              <td>
                <a href="edit.php?id=<?php echo $room['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> Edit</a>
                <a href="delete.php?id=<?php echo $room['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i> Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
