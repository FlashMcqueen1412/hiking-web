<?php
    session_start();
    require 'connexion.php';
    if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
        session_unset();
        session_destroy();
        header("Location: newHiker.php");
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
</body>
</html>