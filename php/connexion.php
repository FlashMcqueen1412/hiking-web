<?php
require 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $pass = $_POST['password'] ?? '';

    $sql = 'SELECT * FROM utilisateurs WHERE user = :user';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user' => $user]);

    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur && password_verify($pass, $utilisateur['password'])) {
        echo "Connexion réussie, bon retour $user !";
    } else {
        echo 'Mauvais identifiant ou mot de passe.';
    }
}
?>

<form method="post" action=""<?php echo $_SERVER['PHP_SELF']; ?>">
    <label>Utilisateur :</label>
    <input type="text" name="user" required>
    <br>
    <label>Mot de passe :</label>
    <input type="password" name="password" required>
    <br>
    <button type="submit">Se connecter</button>
</form>


