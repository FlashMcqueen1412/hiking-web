<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["loggedIn"])) {
    header("Location: connexion.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../image/hiking_icon.png">
    <title>Hike</title>
</head>
<body>
    <h1>Bravo t'es connecter</h1>
    <a href="../index.html">Retour a l'index</a>
</body>
</html>