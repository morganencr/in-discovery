<?php
session_start();
include '../connect.php';

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the ID of the suggestion to delete
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id > 0) {
        try {
            // Prepare and execute the delete query
            $sql = "DELETE FROM suggestions WHERE id_suggestion = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);

            $_SESSION['success'] = "Suggestion supprimée avec succès.";
        } catch (PDOException $e) {
            $_SESSION['errors'] = ["Erreur : " . $e->getMessage()];
        }
    } else {
        $_SESSION['errors'] = ["ID invalide pour la suppression."];
    }

    // Redirect to suggestions page
    header("Location: view_suggestions.php");
    exit();
}
?>