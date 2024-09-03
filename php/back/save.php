<?php
include_once '../connect.php';

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

if (!isset($_POST['type']) || !isset($_POST['id'])) {
    die("Type de modification ou ID non spécifié");
}

$type = $_POST['type'];

try {
    if ($type === 'artiste') {
        $nom = isset($_POST['nom']) ? $_POST['nom'] : null;
        $id_genre = isset($_POST['id_genre']) ? intval($_POST['id_genre']) : null;
        $location = isset($_POST['location']) ? $_POST['location'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $photo = isset($_POST['photo']) ? $_POST['photo'] : null;
        $reseaux_sociaux = isset($_POST['reseaux_sociaux']) ? $_POST['reseaux_sociaux'] : null;
        $decouverte = isset($_POST['decouverte']) ? 1 : 0;
        $cdc = isset($_POST['cdc']) ? 1 : 0;
        $id = intval($_POST['id']);

        if ($id) {
            $stmt = $db->prepare("UPDATE artistes SET nom = :nom, id_genre = :id_genre, location = :location, description = :description, photo = :photo, reseaux_sociaux = :reseaux_sociaux, decouverte = :decouverte, cdc = :cdc WHERE id_artiste = :id");
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':id_genre', $id_genre, PDO::PARAM_INT);
            $stmt->bindParam(':location', $location, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);
            $stmt->bindParam(':reseaux_sociaux', $reseaux_sociaux, PDO::PARAM_STR);
            $stmt->bindParam(':decouverte', $decouverte, PDO::PARAM_INT);
            $stmt->bindParam(':cdc', $cdc, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $db->prepare("INSERT INTO artistes (nom, id_genre, location, description, photo, reseaux_sociaux, decouverte, cdc) VALUES (:nom, :id_genre, :location, :description, :photo, :reseaux_sociaux, :decouverte, :cdc)");
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':id_genre', $id_genre, PDO::PARAM_INT);
            $stmt->bindParam(':location', $location, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);
            $stmt->bindParam(':reseaux_sociaux', $reseaux_sociaux, PDO::PARAM_STR);
            $stmt->bindParam(':decouverte', $decouverte, PDO::PARAM_INT);
            $stmt->bindParam(':cdc', $cdc, PDO::PARAM_INT);
            $stmt->execute();
        }
    } elseif ($type === 'concert') {
        $photo = isset($_POST['photo']) ? $_POST['photo'] : null;
        $groupe = isset($_POST['groupe']) ? $_POST['groupe'] : null;
        $lieux = isset($_POST['lieux']) ? $_POST['lieux'] : null;
        $id = intval($_POST['id']);

        if ($id) {
            $stmt = $db->prepare("UPDATE concerts SET photo = :photo, groupe = :groupe, lieux = :lieux WHERE id_concert = :id");
            $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);
            $stmt->bindParam(':groupe', $groupe, PDO::PARAM_STR);
            $stmt->bindParam(':lieux', $lieux, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $db->prepare("INSERT INTO concerts (photo, groupe, lieux) VALUES (:photo, :groupe, :lieux)");
            $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);
            $stmt->bindParam(':groupe', $groupe, PDO::PARAM_STR);
            $stmt->bindParam(':lieux', $lieux, PDO::PARAM_STR);
            $stmt->execute();
        }
    } else {
        die("Type de modification invalide");
    }

    header("Location: interface-gestion.php");
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>