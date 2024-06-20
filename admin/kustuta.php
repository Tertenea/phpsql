<?php
include '../config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Kustutab kõik hinnangud, mis on seotud toidukohaga
    $stmt = $mysqli->prepare('DELETE FROM hinnangud WHERE toidukoha_id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();

    // Kustutab toidukoha
    $stmt = $mysqli->prepare('DELETE FROM toidukohad WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();

    header('Location: index.php');
    exit();
}
?>
