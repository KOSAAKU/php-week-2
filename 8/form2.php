<?php
session_start();

$host = 'localhost';
$dbName = 'FORM2';
$user = 'root';
$password = '';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die($e->getMessage());
}

$message = "";

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $pass = $_POST['password'];

    if (empty($username)) {
        $message = "Le champ username de l'inscription est vide";
    } elseif (empty($pass)) {
        $message = "Le champ password de l'inscription est vide";
    } else {
        $stmt = $dbh->prepare("SELECT * FROM TABLEFORM2 WHERE username = :username");
        $stmt->execute(['username' => $username]);
        
        if ($stmt->fetch()) {
            $message = "Ce nom d'utilisateur est déjà utilisé";
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $dbh->prepare("INSERT INTO TABLEFORM2 (username, password) VALUES (:username, :password)");
            
            if ($stmt->execute(['username' => $username, 'password' => $hash])) {
                $_SESSION['username'] = $username;
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    }
}

if (isset($_POST['connect'])) {
    $username = trim($_POST['username']);
    $pass = $_POST['password'];

    if (empty($username)) {
        $message = "Le champ username est vide";
    } elseif (empty($pass)) {
        $message = "Le champ password est vide";
    } else {
        $stmt = $dbh->prepare("SELECT * FROM TABLEFORM2 WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $userFound = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userFound) {
            $message = "L'username n'existe pas dans la base de données";
        } else {
            if (password_verify($pass, $userFound['password'])) {
                $_SESSION['username'] = $userFound['username'];
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $message = "Le mot de passe est invalide";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TP Login</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        h1 { margin-top: 30px; }
        form { margin-bottom: 20px; border: 1px solid #ccc; padding: 20px; width: 300px; }
        label { display: block; margin-top: 10px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 5px; margin-top: 5px; box-sizing: border-box; }
        input[type="submit"] { margin-top: 15px; padding: 5px 10px; cursor: pointer; }
        .message { padding: 15px; background: #ffdddd; border: 1px solid #ffcccc; color: #a00000; margin-bottom: 20px; }
        .logout-btn { background-color: #f44336; color: white; border: none; }
    </style>
</head>
<body>

    <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['username'])): ?>
        
        <h1>Bonjour <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <p>Vous êtes connecté.</p>
        
        <form method="get" action="" style="border:none; padding:0;">
            <input type="submit" name="logout" value="Se déconnecter" class="logout-btn">
        </form>

    <?php else: ?>

        <h1>Inscription</h1>
        <form method="post" action="">
            <label>Username :</label>
            <input type="text" name="username">
            
            <label>Password :</label>
            <input type="password" name="password">
            
            <input type="submit" value="Valider" name="register">
        </form>

        <h1>Connection</h1>
        <form method="post" action="">
            <label>Username :</label>
            <input type="text" name="username">
            
            <label>Password :</label>
            <input type="password" name="password">
            
            <input type="submit" value="Valider" name="connect">
        </form>

    <?php endif; ?>

</body>
</html>