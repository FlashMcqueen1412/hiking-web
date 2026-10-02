<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_index.css">
    <link rel="icon" type="image/x-icon" href="image/hiking_icon.png">
    <title>Hiking time</title>
</head>
<body>
    <h1>Time to hike</h1>
<section>
    <form action="hike.php" method="post">
        <label for="name">Enter your name:</label>
        <input type="text" id="name" name="name" required>
        <label for="password">Enter your password:</label>
        <input type="password" id="password" name="password" required>
        <label for="hike">Choose your hike:</label>
        <select name="hike" id="hike">
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
        <input type="submit" value="Start Hike">
    </form>
</section>

<footer>
    <p>New to hiking? <a href="php/newHiker.php">Click here</a> to create an account.</p>
</footer>   
</body>
</html>