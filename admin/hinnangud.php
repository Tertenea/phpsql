<?php
include '../config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$toidukoht_id = $_GET['id'];

$toidukoht_result = $mysqli->prepare('SELECT nimi FROM toidukohad WHERE id = ?');
$toidukoht_result->bind_param('i', $toidukoht_id);
$toidukoht_result->execute();
$toidukoht_result->bind_result($toidukoht_nimi);
$toidukoht_result->fetch();
$toidukoht_result->close();

$hinnangud_result = $mysqli->prepare('SELECT * FROM hinnangud WHERE toidukoha_id = ?');
$hinnangud_result->bind_param('i', $toidukoht_id);
$hinnangud_result->execute();
$hinnangud = $hinnangud_result->get_result();
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Toidukoha Hinnangud - Admin</title>
</head>
<body>
    <h1>Hinnangud toidukohale: <?php echo htmlspecialchars($toidukoht_nimi); ?></h1>
    <a href="index.php">Tagasi Avalehele</a>
    <table border="1">
        <thead>
            <tr>
                <th>Kasutajanimi</th>
                <th>Hinne</th>
                <th>Kommentaar</th>
                <th>Kustuta</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $hinnangud->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nimi']); ?></td>
                    <td><?php echo htmlspecialchars($row['hinne']); ?></td>
                    <td><?php echo htmlspecialchars($row['kommentaar']); ?></td>
                    <td>
                        <form action="kustutahinne.php" method="post">
                            <input type="hidden" name="hinnang_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="toidukoht_id" value="<?php echo $toidukoht_id; ?>">
                            <button type="submit">Kustuta</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
