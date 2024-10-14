<?php
session_start();
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form data
    $nom_artiste = htmlspecialchars(trim($_POST['nom_artiste']), ENT_QUOTES, 'UTF-8');
    $lien_titre = filter_input(INPUT_POST, 'lien_titre', FILTER_SANITIZE_URL);
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8') : '';
    $date_suggestion = date('Y-m-d');

    // Data Validation
    $errors = [];

    if (strlen($nom_artiste) < 3 || strlen($nom_artiste) > 255) {
        $errors[] = "Le nom de l'artiste doit avoir entre 3 et 255 caractères.";
    }

    if (!filter_var($lien_titre, FILTER_VALIDATE_URL)) {
        $errors[] = "Le lien vers le titre doit être une URL valide.";
    }

    if (!empty($message) && (strlen($message) < 10 || strlen($message) > 2000)) {
        $errors[] = "Le message doit avoir entre 10 et 2000 caractères.";
    }

    // If errors are present
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../formulaire.php");
        exit();
    }

    // Inserting data into the database
    try {
        $sql = "INSERT INTO suggestions (nom_artiste, lien_titre, message, date_suggestion) VALUES (:nom_artiste, :lien_titre, :message, :date_suggestion)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nom_artiste', $nom_artiste);
        $stmt->bindParam(':lien_titre', $lien_titre);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':date_suggestion', $date_suggestion);
        $stmt->execute();

        $_SESSION['success'] = "Votre suggestion a été envoyée avec succès.";
        header("Location: ../formulaire.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['errors'] = ["Erreur : " . $e->getMessage()];
        header("Location: ../formulaire.php");
        exit();
    }
}
?>