<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Rediriger si non connecté
if (empty($_SESSION["loggedIn"])) {
    header("Location: connexion.php");
    exit;
}

// Connexion BDD
$host = 'localhost';
$db = 'base_de_donnee';
$pdoUser = 'root';
$pdoPass = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $pdoUser, $pdoPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion : " . $e->getMessage());
}



$stmt = $pdo->prepare("SELECT `hike-Level` FROM user WHERE id = :id");
$stmt->execute([':id' => $_SESSION["user_id"]]);
$userLevel = $stmt->fetchColumn();


$sql = "SELECT * FROM hike
        WHERE FIELD(difficulty, 'VERT', 'BLEU', 'ROUGE', 'ORANGE', 'NOIR') 
              <= FIELD(:level, 'VERT', 'BLEU', 'ROUGE', 'ORANGE', 'NOIR')";
$stmt = $pdo->prepare($sql);
$stmt->execute([':level' => $userLevel]);
$hikes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../image/hiking_icon.png">
    <title>Mes randonnées</title>
</head>

<body class="bg-gray-900 min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="bg-gray-800/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">🥾 Hiking Time</h1>
            <nav class="flex items-center gap-6">
                <span class="flex justify-center text-gray-300 text-sm hidden sm:block">
                    Bonjour, <span
                        class="text-emerald-400 font-medium"><?= htmlspecialchars($_SESSION["username"]) ?></span>
                </span>
                <a href="logout.php"
                    class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg text-sm transition">
                    Déconnexion
                </a>
            </nav>
        </div>
    </header>
    <main class="flex-grow max-w-7xl mx-auto px-4 py-10 w-full">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-white">Mes randonnées</h2>
            <p class="text-gray-400 mt-1">
                Niveau : <span
                    class="text-emerald-400 font-semibold uppercase"><?= htmlspecialchars($userLevel) ?></span>
            </p>
        </div class="mt-12">
<?php foreach ($hikes as $hike): ?>
    <?php $h = $levelStyles[$hike['difficulty']] ?? ['bg' => 'bg-gray-600', 'label' => $hike['difficulty']]; ?>
    <div class="mt-12 bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition">
        <?php if (!empty($hike['image'])): ?>
            <img src="<?= htmlspecialchars($hike['image']) ?>"
                alt="<?= htmlspecialchars($hike['name']) ?>"
                class="w-full h-48 object-cover">
        <?php endif; ?>
        <div class="p-5">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-bold text-white"><?= htmlspecialchars($hike['name']) ?></h3>
                <span class="px-2 py-0.5 rounded-full text-xs text-white font-medium <?= $h['bg'] ?>">
                    <?= $h['label'] ?>
                </span>
            </div>
            <div class="mt-3 flex items-center gap-4 text-xs text-gray-400">
                <span>📏 <?= htmlspecialchars($hike['length_km']) ?> km</span>
                <span>⛰ <?= htmlspecialchars($hike['height_m']) ?> m</span>
                <span>⏱ <?= htmlspecialchars($hike['time']) ?></span>
            </div>
        </div>
    </div>
<?php endforeach; ?>

    </main>
    <footer class="bg-gray-800 border-t border-gray-700 py-8 text-center text-gray-400 text-sm">
        <p>Prend le temps de faire de la randonnée et rendu en haut respire et profite</p>
    </footer>

</body>

</html>