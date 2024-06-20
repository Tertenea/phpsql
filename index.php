<?php
include 'config.php';

$sort_options = ['nimi', 'asukoht', 'keskmine_hinne', 'hinnangud'];
$sort = isset($_GET['sort']) && in_array($_GET['sort'], $sort_options) ? $_GET['sort'] : 'nimi';
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "SELECT * FROM toidukohad WHERE nimi LIKE '%$search%' ORDER BY $sort";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Toidukohad</title>
</head>
<body>
<h1>Toidukohad</h1>
<form method="GET">
    <input type="text" name="search" placeholder="Otsi" value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Otsi</button>
</form>
<table border="1">
    <tr>
        <th><a href="?sort=nimi">Nimi</a></th>
        <th><a href="?sort=asukoht">Asukoht</a></th>
        <th><a href="?sort=keskmine_hinne">Keskmine hinne</a></th>
        <th><a href="?sort=hinnangud">Hinnangute arv</a></th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><a href="hindamine.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nimi']); ?></a></td>
        <td><?php echo htmlspecialchars($row['asukoht']); ?></td>
        <td><?php echo htmlspecialchars($row['keskmine_hinne']); ?></td>
        <td><?php echo htmlspecialchars($row['hinnangud']); ?></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
