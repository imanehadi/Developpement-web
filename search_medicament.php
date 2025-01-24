<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = $_POST['search'];
    $stmt = $pdo->prepare("SELECT * FROM medicaments WHERE nom LIKE ? OR categorie LIKE ? OR dosage LIKE ?");
    $stmt->execute(["%$search%", "%$search%", "%$search%"]);
    $results = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rechercher un Médicament</title>
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
            background-color:rgba(255, 255, 255, 0.2) ;
            width: 100%;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
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
            margin-bottom: 20px;
        }
        form input {
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
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }
        tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
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
            <li><a href="logout.php" style="color: #e74c3c; text-decoration: none; font-weight: bold;">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<main>
    <h2>Rechercher un Médicament</h2>
    <form method="POST">
        <input type="text" name="search" placeholder="Rechercher par nom, catégorie ou dosage" required>
        <button type="submit">Rechercher</button>
    </form>

    <?php if (isset($results)): ?>
        <table>
            <tr>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Dosage</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Date de Péremption</th>
                <th>Quantité</th>
            </tr>
            <?php foreach ($results as $result): ?>
                <tr>
                    <td><?= htmlspecialchars($result['nom']) ?></td>
                    <td><?= htmlspecialchars($result['categorie']) ?></td>
                    <td><?= htmlspecialchars($result['dosage']) ?></td>
                    <td><?= htmlspecialchars($result['description']) ?></td>
                    <td><?= htmlspecialchars($result['prix']) ?></td>
                    <td><?= htmlspecialchars($result['date_peremption']) ?></td>
                    <td><?= htmlspecialchars($result['quantite']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2023 Gestion des Médicaments. Tous droits réservés.</p>
</footer>
</body>
</html>
