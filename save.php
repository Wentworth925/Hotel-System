<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_login();

$room_id       = $_POST['room_id'];
$guest_name    = $_POST['guest_name'];
$guest_contact = $_POST['guest_contact'];
$check_in      = $_POST['check_in'];
$check_out     = $_POST['check_out'];
$notes         = $_POST['notes'];
$total_cost    = $_POST['total_cost'];

$created_by = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$sql = "INSERT INTO reservations 
        (room_id, guest_name, guest_contact, check_in, check_out, notes, total_cost, created_by)
        VALUES 
        (:room_id, :guest_name, :guest_contact, :check_in, :check_out, :notes, :total_cost, :created_by)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':room_id'       => $room_id,
    ':guest_name'    => $guest_name,
    ':guest_contact' => $guest_contact,
    ':check_in'      => $check_in,
    ':check_out'     => $check_out,
    ':notes'         => $notes,
    ':total_cost'    => $total_cost,
    ':created_by'    => $created_by
]);

header("Location: list.php?success=1");
exit;
