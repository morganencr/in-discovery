<?php
include_once '../connect.php';

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

// Check required parameters
if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die("ID ou type non spécifié");
}

// Fetching the parameters
$id = intval($_GET['id']);
$type = $_GET['type'];

try {
    if ($type === 'artiste') {
        // Prepare the querry to delete an artist
        $stmt = $db->prepare("DELETE FROM artistes WHERE id_artiste = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    } elseif ($type === 'concert') {
        // Prepare the query to delete a concert
        $stmt = $db->prepare("DELETE FROM concerts WHERE id_concert = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        die("Type de suppression invalide");
    }

    $stmt->execute();

    // Check if an entry has been deleted
    if ($stmt->rowCount() > 0) {
        // Redirect after success
        header("Location: interface-gestion.php");
        exit();
    } else {
        echo "Erreur : Aucun enregistrement trouvé avec cet ID.";
    }
} catch (PDOException $e) {
    echo "Erreur lors de la suppression : " . $e->getMessage();
}
?>