<?php
$host = 'localhost';
$db   = 'base_de_donnee';
$pdoUser = 'root';
$pdoPass = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $pdoUser, $pdoPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = "";
$password = "";
$formError = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars(trim($_POST["user"] ?? ""), ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars(trim($_POST["password"] ?? ""), ENT_QUOTES, 'UTF-8');

    $sql = "SELECT * FROM user WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);
    $userFound = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userFound && password_verify($password, $userFound['password'])) {
        $_SESSION["loggedIn"]  = true;
        $_SESSION["user_id"]   = $userFound["id"];
        $_SESSION["username"]  = $userFound["username"];

        header("Location: Hike.php");
        exit;
    } else {
        $formError = "Mauvais username ou mot de passe.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_connexion.css">
    <link rel="icon" type="image/png" href="../image/hiking_icon.png">
    <title>Hiking Time</title>
</head>
<body>

<h1>Time to hike</h1>
<section>
    <form method="post" action="connexion.php">
        <label for="user">Enter your username:</label>
        <input type="text" id="user" name="user" value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>" required>
        <label for="password">Enter your password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Start Hike</button>
    </form>
    <div>
        <?php if ($formError !== ""): ?>
            <p style="color:red"><?= htmlspecialchars($formError, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>
</section>

<footer>
    <p>New to hiking? <a href="inscription.php">Click here</a> to create an account.</p>
    <a href="../index.html">Retour a l'index</a>
</body>
</html>