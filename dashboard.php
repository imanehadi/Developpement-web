<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de Bord</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            background-image: url('Capture1.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        header {
            background-color: rgba(255, 255, 255, 0.2);
            width: 100%;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px); /* Effet de flou */
            position: fixed;
            top: 0;
            z-index: 1000;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
            color: #4CAF50;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin-left: 20px;
        }
        nav ul li a {
            color: #000000;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        nav ul li a:hover {
            color: #4CAF50;
        }

        .welcome h2 {
            font-size: 28px;
            color: #fff;
        }
        .welcome p {
            font-size: 18px;
            color: #fff;
        }
        footer {
            background-color: rgba(255, 255, 255, 0.2);
            width: 100%;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            backdrop-filter: blur(10px);
        }
        footer p {
            color: #fff;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="dashboard.php">Tableau de Bord</a></li>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <li><a href="add_medicament.php">Ajouter un Médicament</a></li>
                <li><a href="list_medicaments.php">Liste des Médicaments</a></li>
            <?php endif; ?>
            <li><a href="graph.php">Voir le Graphique</a></li>
            <li><a href="search_medicament.php">Recherche</a></li>
            <li><a href="logout.php" style="color: #117700; text-decoration: none; font-weight: bold;">Déconnexion</a></li>
        </ul>
    </nav>
</header>



<footer>
    <p>&copy; 2023 Gestion des Médicaments. Tous droits réservés.</p>
</footer>
</body>
</html>