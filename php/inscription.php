<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=base_de_donnee;charset=utf8mb4', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$levels = ['VERT', 'BLEU', 'ORANGE', 'ROUGE', 'NOIR'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $hike_Level = $_POST['hike_Level'];

    $errors = [];
    if (empty($username) || empty($password) || empty($hike_Level)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }
    if (!in_array($hike_Level, $levels)) {
        $errors[] = "Niveau invalide.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `user` WHERE `username` = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = "Ce nom d'utilisateur existe déjà.";
        }
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO `user` (`username`, `password`, `hike-Level`) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $hashed_password, $hike_Level])) {
            echo "Inscription réussie !";
        } else {
            echo "Une erreur est survenue lors de l'inscription.";
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_connexion.css">
    <link rel="icon" type="image/x-icon" href="../image/hiking_icon.png">
    <title>New Hiker</title>
</head>

<body>
    <h1>Welcome to Hiking!</h1>
    <section>
        <form method="POST" action="">
            <label>Username : <input type="text" name="username" required></label><br>
            <label>Mot de passe : <input type="password" name="password" required></label><br>
            <label>Confirmer : <input type="password" name="confirm_password" required></label><br>
            <label>Level :
                <select name="hike_Level" required>
                    <option value="VERT">VERT</option>
                    <option value="BLEU">BLEU</option>
                    <option value="ORANGE">ORANGE</option>
                    <option value="ROUGE">ROUGE</option>
                    <option value="NOIR">NOIR</option>
                </select>
            </label><br>
            <button type="submit">S'inscrire</button>
        </form>
    </section>
    <footer>
        <p>Already a hiker? <a href="connexion.php">Click here</a> to connect to your account.</p>
    </footer>
</body>

</html>