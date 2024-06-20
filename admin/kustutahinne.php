<?php
include '../config.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hinnang_id = $_POST['hinnang_id'];
    $toidukoht_id = $_POST['toidukoht_id'];

    $stmt = $conn->prepare('DELETE FROM hinnangud WHERE id = ?');
    $stmt->bind_param('i', $hinnang_id);
    $stmt->execute();
    $stmt->close();

    $update_stmt = $conn->prepare('
        UPDATE toidukohad
        SET keskmine_hinne = (SELECT AVG(hinne) FROM hinnangud WHERE toidukoha_id = ?),
            hinnangud = (SELECT COUNT(*) FROM hinnangud WHERE toidukoha_id = ?)
        WHERE id = ?
    ');
    $update_stmt->bind_param('iii', $toidukoht_id, $toidukoht_id, $toidukoht_id);
    $update_stmt->execute();
    $update_stmt->close();

    header('Location: hinnangud.php?id=' . $toidukoht_id);
    exit();
}
?>
