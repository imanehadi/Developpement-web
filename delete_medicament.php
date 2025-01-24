<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit;
}

if (isset($_POST['delete']) && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the DELETE statement
    $stmt = $pdo->prepare("DELETE FROM medicaments WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        // Redirect back to the list page
        header('Location: list_medicaments.php');
        exit;
    } catch (PDOException $e) {
        // Handle the error (e.g., log it or display a message)
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
} else {
    // Invalid request
    header('Location: list_medicaments.php');
    exit;
}
?>
