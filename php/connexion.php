<?php
$host = 'localhost';
$db = 'base_de_donnee';
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
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $sql = "SELECT * FROM user WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);
    $userFound = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userFound && password_verify($password, $userFound['password'])) {
        $_SESSION["loggedIn"] = true;
        $_SESSION["user_id"] = $userFound["id"];
        $_SESSION["username"] = $userFound["username"];

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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../image/hiking_icon.png">
    <title>Hiking Time</title>
</head>

<body class="bg-gray-900 min-h-screen">
    <header class="bg-gray-800/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                🥾 Hiking Time
            </h1>
            <nav class="hidden md:flex gap-6 text-gray-300">
                <a href="../index.html" class="hover:text-white transition">Accueil</a>
                <a href="#" class="hover:text-white transition">Randonnées</a>
                <a href="#" class="hover:text-white transition">À propos</a>
                <a href="inscription.php"
                    class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-lg transition">Inscrtiption</a>
            </nav>
        </div>
    </header>
    <section class="relative h-64 md:h-96 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&q=80" alt="Paysage de montagnes"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-white">Explorez les sommets</h2>
        </div>
    </section>
    <section>
<main class="flex-grow flex items-center justify-center pt-20">
    <form method="post" action="connexion.php">
        <label class="block text-sm font-medium text-gray-300">Nom d'utilisateur :
            <input type="text" name="username" value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black"></label><br>
        <label class="block text-sm font-medium text-gray-300">Mot de passe :
            <input type="password" name="password" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black"></label><br>
        <?php if ($formError !== ""): ?>
            <p class="text-red-400 text-sm text-center mb-2"><?= htmlspecialchars($formError, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <button type="submit"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Connexion
        </button>
    </form>
</main>   
    </section>

    <footer class="mt-16 bg-gray-800 border-t border-gray-700 py-8 text-center text-gray-400 text-sm ">
        <p>Prend le temps de faire de la randonnée et rendu en haut respire et profite</p>
    </footer>
</body>

</html>