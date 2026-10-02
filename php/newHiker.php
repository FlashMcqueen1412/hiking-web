<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../image/hiking_icon.png">
    <title>New Hiker</title>
</head>
<body>
    <h1>Welcome to Hiking!</h1>
<section>
    <form action="hike.php" method="post">
        <label for="name">Enter your name:</label>
        <input type="text" id="name" name="name" required>
        <label for="password">Enter your password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirm_password">Confirm your password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <input type="submit" value="Start Hike">
    </form>
</section>
</body>
</html>