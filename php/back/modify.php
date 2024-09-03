<?php
include_once '../connect.php';

// Vérification des paramètres URL
if (!isset($_GET['type']) || !isset($_GET['id'])) {
    die("Type ou ID manquant.");
}

$type = $_GET['type'];
$id = intval($_GET['id']);

// Initialisation des variables pour pré-remplir le formulaire
$data = [];
$concert_photos = [];
$all_photos = [];

// Chemins des dossiers
$concert_folder = '../images/next'; // Dossier des photos pour concerts
$all_photos_folder = '../images'; // Dossier des photos pour artistes et découvertes

// Fonction pour récupérer les fichiers d'un dossier et ses sous-dossiers
function getPhotos($dir) {
    $photos = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $fileinfo) {
        if ($fileinfo->isFile() && in_array($fileinfo->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
            // Créer le chemin relatif à partir du dossier racine
            $relative_path = str_replace($dir . '/', '', $fileinfo->getPathname());
            // Conserver le chemin complet pour utiliser dans le formulaire
            $photos[$fileinfo->getFilename()] = 'images/' . $relative_path;
        }
    }
    return $photos;
}

// Récupérer la liste des photos du dossier pour les concerts
if ($type === 'concert') {
    if (is_dir($concert_folder)) {
        $concert_photos = getPhotos($concert_folder);
    } else {
        die("Le dossier des photos pour concerts n'existe pas.");
    }
}

// Récupérer la liste des photos du dossier pour artistes et découvertes
if ($type === 'artiste' || $type === 'decouverte') {
    if (is_dir($all_photos_folder)) {
        $all_photos = getPhotos($all_photos_folder);
    } else {
        die("Le dossier des photos pour artistes et découvertes n'existe pas.");
    }
}

// Requête SQL pour récupérer les données existantes
try {
    switch ($type) {
        case 'artiste':
            $query = $db->prepare("SELECT * FROM artistes WHERE id_artiste = ?");
            break;
        case 'concert':
            $query = $db->prepare("SELECT * FROM concerts WHERE id_concert = ?");
            break;
        case 'decouverte':
            $query = $db->prepare("SELECT * FROM decouvertes WHERE id_decouverte = ?");
            break;
        default:
            die("Type inconnu.");
    }

    $query->execute([$id]);
    $data = $query->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        die("Données non trouvées.");
    }

    // Récupérer la liste des genres pour le menu déroulant
    $genres_query = $db->query("SELECT * FROM genres");
    $genres = $genres_query->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Modifier <?php echo htmlspecialchars($type); ?></title>
    <style>
        .image-preview {
            width: 150px;
            height: auto;
            display: block;
            margin-top: 10px;
        }
    </style>
    <script>
        function previewImage() {
            var select = document.querySelector("select[name='photo']");
            var preview = document.getElementById("imagePreview");
            var selectedOption = select.options[select.selectedIndex].value;

            console.log("Selected option:", selectedOption); // Déboguer la valeur sélectionnée

            if (selectedOption) {
                // Assurez-vous d'utiliser le bon chemin pour les concerts et les autres types
                preview.src = '../images/next/' + selectedOption;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            previewImage(); // Appelle la fonction pour afficher l'image actuelle
        });
    </script>
</head>
<body>
    <h2>Modifier <?php echo htmlspecialchars($type); ?></h2>
    <form method="post" action="save.php" accept-charset="UTF-8">
        <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <?php if ($type === 'artiste' || $type === 'decouverte') : ?>
            <label for="nom">Nom:</label>
            <input type="text" name="nom" value="<?php echo htmlspecialchars($data['nom']); ?>" required><br>

            <label for="id_genre">Genre:</label>
            <select name="id_genre" required>
                <?php foreach ($genres as $genre) : ?>
                    <option value="<?php echo htmlspecialchars($genre['id_genre']); ?>" <?php echo ($genre['id_genre'] == $data['id_genre']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($genre['genre'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label for="location">Lieu:</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($data['location']); ?>" required><br>

            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo htmlspecialchars($data['description']); ?>"><br>

            <label for="photo">Photo:</label>
            <select name="photo" onchange="previewImage()">
                <?php foreach ($all_photos as $filename => $path) : ?>
                    <option value="<?php echo htmlspecialchars($filename); ?>" <?php echo ($filename == $data['photo']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($filename); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <!-- Image de prévisualisation -->
            <img id="imagePreview" class="image-preview" src="../images/<?php echo htmlspecialchars($data['photo']); ?>" alt="Aperçu de l'image"><br>

            <label for="reseaux_sociaux">Réseaux Sociaux:</label>
            <input type="text" name="reseaux_sociaux" value="<?php echo htmlspecialchars($data['reseaux_sociaux']); ?>"><br>

            <label for="decouverte">Découverte:</label>
            <input type="checkbox" name="decouverte" <?php echo ($data['decouverte']) ? 'checked' : ''; ?>><br>

            <label for="cdc">Coup de Coeur:</label>
            <input type="checkbox" name="cdc" <?php echo ($data['cdc']) ? 'checked' : ''; ?>><br>

        <?php endif; ?>

        <?php if ($type === 'concert') : ?>
            <label for="groupe">Groupe:</label>
            <input type="text" name="groupe" value="<?php echo htmlspecialchars($data['groupe']); ?>" required><br>

            <label for="photo">Photo:</label>
            <select name="photo" onchange="previewImage()">
                <?php foreach ($concert_photos as $filename => $path) : ?>
                    <option value="<?php echo htmlspecialchars($filename); ?>" <?php echo ($filename == $data['photo']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($filename); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <!-- Image de prévisualisation -->
            <img id="imagePreview" class="image-preview" src="../images/next/<?php echo htmlspecialchars($data['photo']); ?>" alt="Aperçu de l'image"><br>

            <label for="lieux">Lieux:</label>
            <input type="text" name="lieux" value="<?php echo htmlspecialchars($data['lieux']); ?>"><br>
        <?php endif; ?>

        <input type="submit" value="Sauvegarder">
        <button type="button" onclick="window.history.back()">Annuler</button>
    </form>
</body>
</html>