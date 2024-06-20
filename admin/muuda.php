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

$id = $_GET['id'];
$stmt = $conn->prepare('SELECT * FROM toidukohad WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$toidukoht = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nimi = $_POST['nimi'];
    $asukoht = $_POST['asukoht'];

    $stmt = $conn->prepare('UPDATE toidukohad SET nimi = ?, asukoht = ? WHERE id = ?');
    $stmt->bind_param('ssi', $nimi, $asukoht, $id);
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
    <title>Muuda Toidukoht</title>
</head>
<body>
    <h1>Muuda Toidukoht</h1>
    <form method="post">
        <label for="nimi">Nimi:</label>
        <input type="text" name="nimi" id="nimi" value="<?php echo htmlspecialchars($toidukoht['nimi']); ?>" required>
        <br>
        <label for="asukoht">Asukoht:</label>
        <input type="text" name="asukoht" id="asukoht" value="<?php echo htmlspecialchars($toidukoht['asukoht']); ?>" required>
        <br>
        <button type="submit">Salvesta</button>
    </form>
    <a href="index.php">Tagasi Avalehele</a>
</body>
</html>
