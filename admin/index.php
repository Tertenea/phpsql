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

// Kõikide toidukohtade kuvamine
$result = $conn->query('SELECT * FROM toidukohad');
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Admin Avaleht</title>
</head>
<body>
    <h1>Toidukohtade Haldamine</h1>
    <a href="lisa.php">Lisa Toidukoht</a>
    <table border="1">
        <thead>
            <tr>
                <th>Nimi</th>
                <th>Asukoht</th>
                <th>Keskmine Hinne</th>
                <th>Hinnangute Arv</th>
                <th>Vaata Hinnanguid</th>
                <th>Muuda</th>
                <th>Kustuta</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nimi']); ?></td>
                    <td><?php echo htmlspecialchars($row['asukoht']); ?></td>
                    <td><?php echo htmlspecialchars($row['keskmine_hinne']); ?></td>
                    <td><?php echo htmlspecialchars($row['hinnangud']); ?></td>
                    <td><a href="hinnangud.php?id=<?php echo $row['id']; ?>">Vaata Hinnanguid</a></td>
                    <td><a href="muuda.php?id=<?php echo $row['id']; ?>">Muuda</a></td>
                    <td><a href="kustuta.php?id=<?php echo $row['id']; ?>">Kustuta</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
