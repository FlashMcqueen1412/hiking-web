<?php
$user = "";
$password = "";
$level = "";
// errreur 
$erreuruser = "";
// e G 
$erreurGlobal = false;
$erreurLogin = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //  Courriel 
    //  MotDePasse
    $user = htmlspecialchars(trim($_POST["user"] ?? ""), ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars(trim($_POST["password"] ?? ""), ENT_QUOTES, 'UTF-8');
    $level = htmlspecialchars(trim($_POST['level'] ??''), ENT_QUOTES, 'UTF-8');


    if ($user === "") {
        $erreurLogin = "Champ Obligatoire";
        $erreurGlobal = true;
    }
    if ($password === "") {
        $erreurPassword = "Champs Obligatoire";
        $erreurGlobal = true;
    }
    // hasher le mdp  
    $password = password_hash($password, PASSWORD_DEFAULT);


    if ($erreurGlobal === false) {
        require 'connexion.php';
        $sql = "INSERT INTO user(user, password, difficulty) VALUES (?,?,?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $user,
            $password,
            $level
        ]);
        header('Location: Hike.php');

    }
    if ($erreurGlobal == true) {
        echo $erreurGlobal;
    }
}
$user = "";
$password = "";
$level = "";

?>