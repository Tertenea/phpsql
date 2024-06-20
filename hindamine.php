<?php
include 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$toidukoha_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nimi = $_POST['nimi'];
    $hinne = (int)$_POST['hinne'];
    $kommentaar = $_POST['kommentaar'];

    if (empty($nimi) || empty($hinne) || empty($kommentaar)) {
        $error = "Kõik väljad on kohustuslikud!";
    } else {
        $stmt = $conn->prepare("INSERT INTO hinnangud (toidukoha_id, nimi, hinne, kommentaar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $toidukoha_id, $nimi, $hinne, $kommentaar);
        $stmt->execute();

        $conn->query("UPDATE toidukohad SET 
            keskmine_hinne = (SELECT AVG(hinne) FROM hinnangud WHERE toidukoha_id = $toidukoha_id), 
            hinnangud = (SELECT COUNT(*) FROM hinnangud WHERE toidukoha_id = $toidukoha_id) 
            WHERE id = $toidukoha_id");

        header("Location: index.php");
        exit;
    }
}

$toidukoht = $conn->query("SELECT * FROM toidukohad WHERE id = $toidukoha_id")->fetch_assoc();
$hinnangud = $conn->query("SELECT * FROM hinnangud WHERE toidukoha_id = $toidukoha_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hinda <?php echo htmlspecialchars($toidukoht['nimi']); ?></title>
</head>
<body>
<h1>Hinda <?php echo htmlspecialchars($toidukoht['nimi']); ?></h1>
<?php if ($error): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="POST">
    <label for="nimi">Nimi:</label>
    <input type="text" name="nimi" id="nimi" required><br>

    <label for="hinne">Hinne (1-10):</label>
    <input type="radio" class="rating-input" id="hinne" name="hinne" value="1">
    <input type="radio" class="rating-input" id="hinne" name="hinne" value="2">
    <input type="radio" class="rating-input" id="hinne" name="hinne" value="3">
    <input type="radio" class="rating-input" id="hinne" name="hinne" value="4">
    <input type="radio" class="rating-input" id="hinne" name="hinne" value="5">
    <input type="radio" class="rating-input" id="hinne" name="hinne" value="6">
    <input type="radio" class="rating-input" id="hinne" name="hinne" value="7">
    <input type="radio" class="rating-input" id="hinne" name="hinne" value="8">
    <input type="radio" class="rating-input" id="hinne" name="hinne" value="9">
    <input type="radio" class="rating-input" id="hinne" name="hinne" value="10">
    <br>

    <label for="kommentaar">Kommentaar:</label>
    <textarea name="kommentaar" id="kommentaar" required></textarea><br>

    <button type="submit">Saada</button>
</form>

<h2>Hinnangud</h2>
<ul>
    <?php while ($hinnang = $hinnangud->fetch_assoc()): ?>
        <li><strong><?php echo htmlspecialchars($hinnang['nimi']); ?>:</strong> <?php echo htmlspecialchars($hinnang['hinne']); ?>/10 - <?php echo htmlspecialchars($hinnang['kommentaar']); ?></li>
    <?php endwhile; ?>
</ul>
</body>
</html>
