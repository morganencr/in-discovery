<?php
include_once '../connect.php';

// Vérification des champs obligatoires
if (!isset($_POST['type'])) {
    die("Type de modification non spécifié");
}

$type = $_POST['type'];

if ($type === 'artiste') {
    // Validation des champs de l'artiste
    $nom = htmlspecialchars($_POST['nom']);
    $id_genre = intval($_POST['id_genre']);
    $location = htmlspecialchars($_POST['location']);
    $description = htmlspecialchars($_POST['description']);
    $photo = htmlspecialchars($_POST['photo']);
    $reseaux_sociaux = htmlspecialchars($_POST['reseaux_sociaux']);
    $decouverte = isset($_POST['decouverte']) ? 1 : 0;
    $cdc = isset($_POST['cdc']) ? 1 : 0;

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Mettre à jour un artiste existant
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("UPDATE artistes SET nom = ?, id_genre = ?, location = ?, description = ?, photo = ?, reseaux_sociaux = ?, decouverte = ?, cdc = ? WHERE id_artiste = ?");
        $stmt->bind_param("sissssiii", $nom, $id_genre, $location, $description, $photo, $reseaux_sociaux, $decouverte, $cdc, $id);
    } else {
        // Ajouter un nouvel artiste
        $stmt = $conn->prepare("INSERT INTO artistes (nom, id_genre, location, description, photo, reseaux_sociaux, decouverte, cdc) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissssii", $nom, $id_genre, $location, $description, $photo, $reseaux_sociaux, $decouverte, $cdc);
    }
} elseif ($type === 'concert') {
    // Validation des champs de concert
    $photo = htmlspecialchars($_POST['photo']);
    $groupe = htmlspecialchars($_POST['groupe']);
    $lieux = htmlspecialchars($_POST['lieux']);

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Mettre à jour un concert existant
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("UPDATE concerts SET photo = ?, groupe = ?, lieux = ? WHERE id_concert = ?");
        $stmt->bind_param("sssi", $photo, $groupe, $lieux, $id);
    } else {
        // Ajouter un nouveau concert
        $stmt = $conn->prepare("INSERT INTO concerts (photo, groupe, lieux) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $photo, $groupe, $lieux);
    }
} else {
    die("Type de modification invalide");
}

// Exécution de la requête
if ($stmt->execute()) {
    echo "Enregistrement réussi!";
} else {
    echo "Erreur: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>