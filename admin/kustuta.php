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
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];

        $stmt = $conn->prepare('DELETE FROM hinnangud WHERE toidukoha_id = ?');
        if ($stmt) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "viga";
            exit();
        }

        $stmt = $conn->prepare('DELETE FROM toidukohad WHERE id = ?');
        if ($stmt) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "viga";
            exit();
        }

        header('Location: index.php');
        exit();
    } else {
        echo "ID ei ole.";
        exit();
    }
} else {
    echo "viga";
    exit();
}
?>
