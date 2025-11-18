<?php
require '../includes/auth.php';
require '../includes/db.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $room_id = intval($_POST['room_id']);
    $guest_name = $_POST['guest_name'];
    $guest_contact = $_POST['guest_contact'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $notes = $_POST['notes'];
    $total_cost = floatval($_POST['total_cost']);

    $stmt = $pdo->prepare("UPDATE reservations SET room_id=?, guest_name=?, guest_contact=?, check_in=?, check_out=?, notes=?, total_cost=? WHERE id=?");
    $stmt->execute([$room_id, $guest_name, $guest_contact, $check_in, $check_out, $notes, $total_cost, $id]);

    header('Location: list.php');
    exit;
} else {
    header('Location: list.php');
    exit;
}
