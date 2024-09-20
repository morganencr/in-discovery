<?php

session_start();

$inactivityLimit = 1800;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactivityLimit)) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit;
}

$_SESSION['last_activity'] = time();

include_once '../connect.php';

// Checking URL parameters
if (!isset($_GET['type']) || !isset($_GET['id'])) {
    die("Type ou ID manquant.");
}

$type = $_GET['type'];
$id = intval($_GET['id']);

// Initializing variables to pre-fill the form
$data = [];
$concert_photos = [];
$all_photos = [];

// Folder paths
$concert_folder = '../images/next'; // Concert photo file
$all_photos_folder = '../images/artistes'; // File of photos for artists and discoveries

// Function to recover files from a folder and its subfolders
function getPhotos($dir) {
    $photos = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $fileinfo) {
        if ($fileinfo->isFile() && in_array($fileinfo->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
            // Create relative path from root folder
            $relative_path = str_replace($dir . '/', '', $fileinfo->getPathname());
            // Keep full path for use in form
            $photos[$fileinfo->getFilename()] = 'images/' . $relative_path;
        }
    }
    return $photos;
}

// Fetch list of photos from folder for concerts
if ($type === 'concert') {
    if (is_dir($concert_folder)) {
        $concert_photos = getPhotos($concert_folder);
    } else {
        die("Le dossier des photos pour concerts n'existe pas.");
    }
}

// Retrieve list of photos from folder for artistes and découvertes
if ($type === 'artiste' || $type === 'decouverte') {
    if (is_dir($all_photos_folder)) {
        $all_photos = getPhotos($all_photos_folder);
    } else {
        die("Le dossier des photos pour artistes et découvertes n'existe pas.");
    }
}

// SQL query to retrieve existing data
try {
    switch ($type) {
        case 'artiste':
            $query = $db->prepare("SELECT * FROM artistes WHERE id_artiste = ?");
            break;
        case 'concert':
            $query = $db->prepare("SELECT * FROM concerts WHERE id_concert = ?");
            break;
        default:
            die("Type inconnu.");
    }

    $query->execute([$id]);
    $data = $query->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        die("Données non trouvées.");
    }

    // Retrieve genre list for dropdown menu
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="modify.css">
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

        var basePath = '<?php echo $type === 'concert' ? '../images/next/' : '../images/artistes/'; ?>';
        if (selectedOption) {
            preview.src = basePath + selectedOption;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

    function previewImage2() {
    var select = document.querySelector("select[name='photo2']");
    var preview = document.getElementById("imagePreview2");
    var selectedOption = select.options[select.selectedIndex].value;

    var basePath = '<?php echo $type === 'concert' ? '../images/next/' : '../images/artistes/'; ?>';
    if (selectedOption) {
        preview.src = basePath + selectedOption;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}

document.addEventListener("DOMContentLoaded", function() {
    previewImage();  // Call the fonction to display 'photo'
    previewImage2(); // Call the fonction to display 'photo2'
    });


</script>
</head>
<body>
    <h1>Modifier <?php echo htmlspecialchars($type); ?></h1>
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

            <label for="photo">Photo pour index:</label>
            <select name="photo" onchange="previewImage()">
                <?php foreach ($all_photos as $filename => $path) : ?>
                    <option value="<?php echo htmlspecialchars($filename); ?>" <?php echo ($filename == $data['photo']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($filename); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            <img id="imagePreview" class="image-preview" src="../images/artistes/<?php echo htmlspecialchars($data['photo']); ?>" alt="Aperçu de l'image"><br>

            <label for="photo2">Photo pour Artistes:</label>
<select name="photo2" onchange="previewImage2()">
    <?php foreach ($all_photos as $filename => $path) : ?>
        <option value="<?php echo htmlspecialchars($filename); ?>" <?php echo ($filename == $data['photo2']) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($filename); ?>
        </option>
    <?php endforeach; ?>
</select>
<img id="imagePreview2" class="image-preview" src="../images/artistes/<?php echo htmlspecialchars($data['photo2']); ?>" alt="Aperçu de la deuxième image"><br>

            <label for="reseaux_sociaux">Réseaux Sociaux:</label>
            <input type="text" name="reseaux_sociaux" value="<?php echo htmlspecialchars($data['reseaux_sociaux']); ?>"><br>

            <label for="audio_url">URL de l'audio:</label>
            <input type="text" name="audio_url" value="<?php echo htmlspecialchars($data['audio_url']); ?>"><br>

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

            <!-- Preview image -->
            <img id="imagePreview" class="image-preview" src="../images/next/<?php echo htmlspecialchars($data['photo']); ?>" alt="Aperçu de l'image"><br>

            <label for="lieux">Lieux:</label>
            <input type="text" name="lieux" value="<?php echo htmlspecialchars($data['lieux']); ?>"><br>
        <?php endif; ?>

        <input type="submit" value="Sauvegarder">
        <button type="button" onclick="window.history.back()">Annuler</button>
    </form>
</body>
</html>