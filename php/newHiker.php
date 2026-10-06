
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_index.css">
    <link rel="icon" type="image/x-icon" href="../image/hiking_icon.png">
    <title>New Hiker</title>
</head>
         <?php require 't_inscription.php'; ?>
<body>
    <h1>Welcome to Hiking!</h1>
<section>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <label for="name">Enter your username:</label>
        <input type="text" id="name" name="name" required>
        <label for="password">Enter your password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirm_password">Confirm your password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <label for="hike">Your hiking level:</label>
        <select name="hike" id="hike">
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