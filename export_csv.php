<?php
require 'includes/auth.php';
require 'includes/db.php';
require_login();

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="reservations.csv"');

$out = fopen('php://output','w');
fputcsv($out, ['ID','Room','Guest','Contact','Check-in','Check-out','Nights','Total','Notes','Created At']);

$stmt = $pdo->query('SELECT r.*, rm.room_number FROM reservations r JOIN rooms rm ON rm.id = r.room_id ORDER BY r.created_at DESC');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $ci = new DateTime($row['check_in']);
    $co = new DateTime($row['check_out']);
    $n = $ci->diff($co)->format('%a');
    fputcsv($out, [
        $row['id'],
        $row['room_number'],
        $row['guest_name'],
        $row['guest_contact'],
        $row['check_in'],
        $row['check_out'],
        $n,
        $row['total_cost'],
        $row['notes'],
        $row['created_at']
    ]);
}
fclose($out);
exit;
?>
