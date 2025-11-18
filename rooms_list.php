<?php
require 'includes/auth.php';
require 'includes/db.php';
require_login();

$rooms = $pdo->query("SELECT * FROM rooms ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Rooms List</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">

<h2>Rooms List</h2>

<table class="table table-striped">
    <thead>
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
            <td><?php echo htmlspecialchars($room['status']); ?></td>
            <td><?php echo htmlspecialchars($room['price']); ?></td>
            <td>
                <a href="edit.php?id=<?php echo $room['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="delete.php?id=<?php echo $room['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="add_room.php" class="btn btn-success">Add Room</a>
<a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>

</div>
</body>
</html>
