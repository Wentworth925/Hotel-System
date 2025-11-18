<?php

$host = 'localhost';
$dbname = 'hotel_system_final'; 
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$stmt = $pdo->query("SELECT * FROM rooms");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rooms List</title>
</head>
<body>
    <h1>Hotel Rooms</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Room Type</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($rooms as $room): ?>
            <tr>
                <td><?php echo $room['id']; ?></td>
                <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                <td><?php echo htmlspecialchars($room['price']); ?></td>
                <td>
                    <a href="edit_room.php?id=<?php echo $room['id']; ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="add_room.php">Add New Room</a> | <a href="dashboard">Back to Dashboard</a>
</body>
</html>