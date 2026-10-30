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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="../image/hiking_icon.png">
    <title>New Hiker</title>
</head>

<body class="bg-gray-900 min-h-screen">
    <!-- Nav bar -->
    <header class="bg-gray-800/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                🥾 Hiking Time
            </h1>
            <nav class="hidden md:flex gap-6 text-gray-300">
                <a href="../index.html" class="hover:text-white transition">Accueil</a>
                <a href="#" class="hover:text-white transition">Randonnées</a>
                <a href="#" class="hover:text-white transition">À propos</a>
                <a href="connexion.php"
                    class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-lg transition">Connexion</a>
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
            <form method="POST" action="" class="space-y-4">
                <label class="block text-sm font-medium text-gray-300">Nom d'utilisateur :
                    <input type="text" name="username"
                        required
                        class=" w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black"></label>
                <label class="block text-sm font-medium text-gray-300">Mot de passe : <input type="password"
                        name="password" required
                        class="  w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black"></label>
                <label class="block text-sm font-medium text-gray-300">Confirmer : <input type="password"
                        name="confirm_password" required
                        class=" w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black"></label>
                <label class="block text-sm font-medium text-gray-300">Niveau de difficulté :
                    <select name="hike_Level" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black">
                        <option value="VERT">VERT</option>
                        <option value="BLEU">BLEU</option>
                        <option value="ORANGE">ORANGE</option>
                        <option value="ROUGE">ROUGE</option>
                        <option value="NOIR">NOIR</option>
                    </select>
                </label>
                <button type="submit" type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">S'inscrire</button>
            </form>
    </section>
    </main>
    <footer class="mt-16 bg-gray-800 border-t border-gray-700 py-8 text-center text-gray-400 text-sm ">
        <p>Prend le temps de faire de la randonnée et rendu en haut respire et profite</p>
    </footer>
</body>

</html>