<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $categorie = $_POST['categorie'];
    $dosage = $_POST['dosage'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $date_peremption = $_POST['date_peremption'];
    $quantite = $_POST['quantite'];

    $stmt = $pdo->prepare("INSERT INTO medicaments (nom, categorie, dosage, description, prix, date_peremption, quantite) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $categorie, $dosage, $description, $prix, $date_peremption, $quantite]);
    echo "Médicament ajouté avec succès.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Médicament</title>
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
        main {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1200px;
            margin-top: 100px;
            backdrop-filter: blur(10px);
        }
        form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        form input, form textarea, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        form button:hover {
            background-color: #117700;
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

<main>
    <h2>Ajouter un Médicament</h2>
    <form method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" required>
        <label>Catégorie :</label>
        <input type="text" name="categorie" required>
        <label>Dosage :</label>
        <input type="text" name="dosage" required>
        <label>Description :</label>
        <textarea name="description" required></textarea>
        <label>Prix :</label>
        <input type="number" step="0.01" name="prix" required>
        <label>Date de Péremption :</label>
        <input type="date" name="date_peremption" required>
        <label>Quantité :</label>
        <input type="number" name="quantite" required>
        <button type="submit">Ajouter</button>
    </form>
</main>


</body>
</html>
