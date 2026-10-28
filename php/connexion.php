<?php
$host = 'localhost';
$db   = 'base_de_donnee';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_connexion.css">
    <link rel="icon" type="../image/x-icon" href="../image/hiking_icon.png">
    <title>Hiking time</title>
</head>
<body>

<?php
    // les variables
    $user = "";
    $password = "";
    $formError = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user = htmlspecialchars(trim($_POST["user"] ?? ""), ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars(trim($_POST["password"] ?? ""), ENT_QUOTES, 'UTF-8');

        $sql = "SELECT * FROM user WHERE user = :user";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user' => $user]);
        $userCompatible = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === $userCompatible['user'] && password_verify($password, $userCompatible['password'])) {
            $_SESSION["loggedIn"] = true;
            $_SESSION["user_id"] = $userCompatible["id"];

            // if ($userCompatible[role] == "admin") {
            //     $_SESSION["user_admin"] = true;
            // }

            header("Location: Hike.php");

            exit;
        } else {
            $formError = "Mauvais username ou mot de passe.";
        }
    }
    ?>
    <h1>Time to hike</h1>
<section>
    <form method="post" action="connexion.php">
        <label for="name">Enter your username:</label>
        <input type="text" id="user" name="user" value="<?= htmlspecialchars($user, ENT_QUOTES, 'UTF-8') ?>" required>
        <label for="password">Enter your password:</label>
        <input type="password" id="password" name="password" value="<?= htmlspecialchars($password, ENT_QUOTES, 'UTF-8') ?>" required>
        <button type="submit">Start Hike</button>
    </form>
          <div>
            <?php if ($formError !== ""): ?>
                <p><?= htmlspecialchars($formError, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
        </div>
</section>
  <h1 id="content"></h1>
<footer>
    <p>New to hiking? <a href="inscription.php">Click here</a> to create an account.</p>
</footer>
</body>
</html>