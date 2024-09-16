<?php
include_once '../connect.php';

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

// Vérification des paramètres requis
if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die("ID ou type non spécifié");
}

// Récupération des paramètres
$id = intval($_GET['id']);
$type = $_GET['type'];

try {
    if ($type === 'artiste') {
        // Préparer la requête pour supprimer un artiste
        $stmt = $db->prepare("DELETE FROM artistes WHERE id_artiste = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    } elseif ($type === 'concert') {
        // Préparer la requête pour supprimer un concert
        $stmt = $db->prepare("DELETE FROM concerts WHERE id_concert = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        die("Type de suppression invalide");
    }

    $stmt->execute();

    // Vérifiez si une ligne a été supprimée
    if ($stmt->rowCount() > 0) {
        // Redirection après succès
        header("Location: interface-gestion.php");
        exit();
    } else {
        echo "Erreur : Aucun enregistrement trouvé avec cet ID.";
    }
} catch (PDOException $e) {
    echo "Erreur lors de la suppression : " . $e->getMessage();
}
?>