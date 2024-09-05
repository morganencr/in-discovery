<?php
session_start();
include '../connect.php';  // Assurez-vous que le chemin est correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom_artiste = trim($_POST['nom_artiste']);
    $lien_titre = filter_input(INPUT_POST, 'lien_titre', FILTER_SANITIZE_URL);
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $date_suggestion = date('Y-m-d');

    // Validation des données
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

    // Si des erreurs sont présentes
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../formulaire.php");
        exit();
    }

    // Insertion des données dans la base de données
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