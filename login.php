<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('image4.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #fff;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 350px;
            text-align: center;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 6px;
            font-size: 14px;
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }
        .login-container input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .login-container input:focus {
            border-color: #fff;
            outline: none;
            background-color: rgba(255, 255, 255, 0.3);
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: transparent;
            border: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 6px;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .login-container button:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: #fff;
        }
        .error {
            color: #ff4d4d;
            margin-bottom: 15px;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Adresse email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
</div>
</body>
</html>

