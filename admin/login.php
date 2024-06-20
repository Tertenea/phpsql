<?php
include '../config.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kasutajanimi = $_POST['kasutajanimi'];
    $pass = $_POST['pass'];

    $stmt = $conn->prepare('SELECT parool FROM kasutajad WHERE kasutajanimi = ?');
    $stmt->bind_param('s', $kasutajanimi);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        if (password_verify($pass, $hashedPassword)) {
            $_SESSION['admin'] = $kasutajanimi;
            header('Location: index.php');
            exit();
        } else {
            $viga = 'saamatu';
        }
    } else {
        $viga = 'saamatu';
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>admin login</title>
</head>
<body>
    <h1>admin login</h1>
    <sup>user: mario, pass: 1551</sup>
    <form method="post">
        <label for="kasutajanimi">usernam:</label>
        <input type="text" name="kasutajanimi" id="kasutajanimi" required>
        <label for="pass">pass:</label>
        <input type="password" name="pass" id="pass" required>
        <button type="submit">login</button>
    </form>
    <?php
    if (isset($viga)) {
        echo "<p style='color:red;'>$viga</p>";
    }
    ?>
</body>
</html>
