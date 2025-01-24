<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}


$stmt = $pdo->query("SELECT categorie, SUM(quantite) as total FROM medicaments GROUP BY categorie");
$categories = [];
$quantities = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $categories[] = $row['categorie'];
    $quantities[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Graphique des Médicaments</title>
    <!-- Inclure Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            background-color: rgba(255, 255, 255, 0.3);
            width: 100%;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            background-color: transparent;
        }
        nav ul li {
            margin-left: 20px;
        }
        nav ul li a {
            color: #000000;
            text-decoration: none;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        main {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1200px;
            margin-top: 20px;
        }
        .chart-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 40px;
        }
        footer {
            background-color: rgba(255, 255, 255, 0.9);
            width: 100%;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
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
            <li><a href="logout.php" style="color: #fff; text-decoration: none; font-weight: bold;">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="chart-container">
        <h2>Progression des Produits</h2>
        <canvas id="productChart"></canvas>
    </section>
</main>

<footer>
    <p>&copy; 2023 Gestion des Médicaments. Tous droits réservés.</p>
</footer>

<!-- Script pour initialiser le graphique -->
<script>
    const categories = <?= json_encode($categories) ?>;
    const quantities = <?= json_encode($quantities) ?>;

    const ctx = document.getElementById('productChart').getContext('2d');
    const productChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: categories,
            datasets: [{
                label: 'Quantité de médicaments par catégorie',
                data: quantities,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Progression des Produits par Catégorie'
                }
            }
        }
    });
</script>
</body>
</html>
