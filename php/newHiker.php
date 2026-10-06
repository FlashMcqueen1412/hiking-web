<?php 
    session_start();
    require 'inscription.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_index.css">
    <link rel="icon" type="image/x-icon" href="../image/hiking_icon.png">
    <title>New Hiker</title>
</head>

<body>
    <h1>Welcome to Hiking!</h1>
    <section>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <label for="name">Enter your username:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($prenom ?? '') ?>" required>
            <label for="password">Enter your password:</label>
            <input type="password" id="password" name="password" value="<?= htmlspecialchars($password ?? '') ?>" required>
            <label for="hike">Your hiking level:</label>
            <select name="difficulty" id="hike" value="<?= htmlspecialchars($level ?? '') ?>">
                <option value="EASY">Easy</option>
                <option value="MEDIUM">Medium</option>
                <option value="HARD">Hard</option>
                <option value="EXTREME">Extreme</option>
            </select>
            <input type="submit" value="Start Hike">
        </form>
    </section>
    <footer>
        <p>Already a hiker? <a href="../index.php">Click here</a> to connect to your account.</p>
    </footer>
</body>

</html>