<?php
include '../config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nimi = $_POST['nimi'];
    $asukoht = $_POST['asukoht'];

    $stmt = $conn->prepare('INSERT INTO toidukohad (nimi, asukoht, keskmine_hinne, hinnangud) VALUES (?, ?, 0, 0)');
    $stmt->bind_param('ss', $nimi, $asukoht);
    $stmt->execute();
    $stmt->close();

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Lisa Toidukoht</title>
</head>
<body>
    <h1>Lisa Uus Toidukoht</h1>
    <form method="post">
        <label for="nimi">Nimi:</label>
        <input type="text" name="nimi" id="nimi" required>
        <br>
        <label for="asukoht">Asukoht:</label>
        <input type="text" name="asukoht" id="asukoht" required>
        <br>
        <button type="submit">Lisa</button>
    </form>
    <a href="index.php">Tagasi Avalehele</a>
</body>
</html>
