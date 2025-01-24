<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM medicaments");
$medicaments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Médicaments</title>
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
            background-color: #e6efe2;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1200px;
            margin-top: 100px;
            backdrop-filter: blur(10px);
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
            background-color: #117700;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }
        tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .delete-button {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }
        .delete-button:hover {
            background-color: #c0392b;
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
            <li><a href="logout.php" style="color: #e74c3c; text-decoration: none; font-weight: bold;">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<main>
    <h2>Liste des Médicaments</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Dosage</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Date de Péremption</th>
            <th>Quantité</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($medicaments as $medicament): ?>
            <tr>
                <td><?= htmlspecialchars($medicament['nom']) ?></td>
                <td><?= htmlspecialchars($medicament['categorie']) ?></td>
                <td><?= htmlspecialchars($medicament['dosage']) ?></td>
                <td><?= htmlspecialchars($medicament['description']) ?></td>
                <td><?= htmlspecialchars($medicament['prix']) ?></td>
                <td><?= htmlspecialchars($medicament['date_peremption']) ?></td>
                <td><?= htmlspecialchars($medicament['quantite']) ?></td>
                <td>
                    <form method="POST" action="delete_medicament.php">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($medicament['id']) ?>">
                        <button type="submit" name="delete" class="delete-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce médicament?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>

<footer>
    <p>&copy; 2023 Gestion des Médicaments. Tous droits réservés.</p>
</footer>
</body>
</html>