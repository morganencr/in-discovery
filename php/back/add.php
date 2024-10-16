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

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

$type = $_GET['type'] ?? '';

// Fetch the genres from the database
$genres = [];
try {
    $sql = "SELECT id_genre, genre FROM genres";
    $stmt = $db->query($sql);
    $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des genres : " . $e->getMessage();
}


function getImagesFromDirectory($directory) {
    $images = [];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (is_dir($directory)) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $extension = strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                if (in_array($extension, $allowedExtensions)) {
                    $relativePath = str_replace(realpath(__DIR__ . '/../'), '', realpath($file->getPathname()));
                    $relativePath = ltrim($relativePath, '/');
                    $images[$file->getFilename()] = $relativePath;
                }
            }
        }
    }
    return $images;
}

// Define images folders
$concert_folder = __DIR__ . '/../images/next';
$all_photos_folder = __DIR__ . '/../images';

// Fetch the images based on the type
if ($type === 'concert') {
    $photos = getImagesFromDirectory($concert_folder);
} else {
    $photos = getImagesFromDirectory($all_photos_folder);
}

// Form processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Fetching the photo
    $photo = $_POST['photo'] ?? '';

    if ($action === 'add') {
        try {
            if ($type === 'artiste') {
                $sql = "INSERT INTO artistes (nom, id_genre, location, description, photo, photo2, reseaux_sociaux, audio_url, decouverte, cdc) VALUES (:nom, :id_genre, :location, :description, :photo, :photo2, :reseaux_sociaux, :audio_url, :decouverte, :cdc)";
            } elseif ($type === 'decouverte') {
                $sql = "INSERT INTO decouvertes (nom, id_genre, location) VALUES (:nom, :id_genre, :location)";
            } elseif ($type === 'concert') {
                $sql = "INSERT INTO concerts (photo, groupe, lieux) VALUES (:photo, :groupe, :lieux)";
            }

            $stmt = $db->prepare($sql);

            // Prepare the parameters
            $params = [
                ':nom' => $_POST['nom'] ?? '',
                ':id_genre' => $_POST['id_genre'] ?? '',
                ':location' => $_POST['location'] ?? '',
                ':description' => $_POST['description'] ?? '',
                ':photo' => $_POST['photo'] ?? '',
                ':photo2' => $_POST['photo2'] ?? '',
                ':reseaux_sociaux' => $_POST['reseaux_sociaux'] ?? '',
                ':audio_url' => $_POST['audio_url'] ?? '',
                ':decouverte' => isset($_POST['decouverte']) ? 1 : 0,
                ':cdc' => isset($_POST['cdc']) ? 1 : 0,
                ':groupe' => $_POST['groupe'] ?? '',
                ':lieux' => $_POST['lieux'] ?? ''
            ];

            // Filter the parameters according to the SQL query
            $params = array_filter($params, function($v, $k) use ($sql) {
                return strpos($sql, $k) !== false;
            }, ARRAY_FILTER_USE_BOTH);

            // Bind the parameters with bindParam
            foreach ($params as $key => $value) {
                $stmt->bindParam($key, $params[$key], PDO::PARAM_STR);
            }

            $stmt->execute();

            // Redirect to the admin page after adding
            if (!headers_sent()) {
                header("Location: interface-gestion.php");
                exit;
            } else {
                echo "Les en-têtes ont déjà été envoyés, redirection impossible.";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../images/logodiscovery.ico">
    <link rel="stylesheet" href="add.css">
    <title>Ajouter un élément</title>
    <script>
        function previewImage() {
            var select = document.getElementById("photo");
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
            var select = document.getElementById("photo2");
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
    </script>
</head>

<body>
    <h1>Ajouter un <?php echo htmlspecialchars($type); ?></h1>

    <form method="POST" action="add.php?type=<?php echo htmlspecialchars($type); ?>" accept-charset="UTF-8">
        <input type="hidden" name="action" value="add">

        <?php if ($type === 'artiste'): ?>
            <!-- Form to add an artist -->
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="id_genre">Genre:</label>
            <select id="id_genre" name="id_genre" required>
                <option value="">Sélectionner un genre</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?php echo htmlspecialchars($genre['id_genre']); ?>">
                        <?php echo htmlspecialchars($genre['genre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="location">Lieu:</label>
            <input type="text" id="location" name="location" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>

            <label for="photo">Photo pour index:</label>
            <select id="photo" name="photo" onchange="previewImage()">
                <option value="">Sélectionner une photo</option>
                <?php
                if (isset($photos) && is_array($photos)) {
                    foreach ($photos as $photo): ?>
                        <option value="<?php echo htmlspecialchars(basename($photo)); ?>"><?php echo htmlspecialchars(basename($photo)); ?></option>
                    <?php endforeach;
                } else {
                    echo "<option value=''>Aucune photo disponible</option>";
                }
                ?>
            </select>
            <img id="imagePreview" class="image-preview" src="../images/artistes/<?php echo htmlspecialchars($data['photo']); ?>">

            <label for="photo2">Photo pour artistes:</label>
            <select id="photo2" name="photo2" onchange="previewImage2()">
                <option value="">Sélectionner une photo</option>
                <?php foreach ($photos as $photo): ?>
                    <option value="<?php echo htmlspecialchars(basename($photo)); ?>"><?php echo htmlspecialchars(basename($photo)); ?></option>
                <?php endforeach; ?>
            </select>
            <img id="imagePreview2" class="image-preview" src="">

            <label for="reseaux_sociaux">Réseaux Sociaux:</label>
            <input type="text" id="reseaux_sociaux" name="reseaux_sociaux">

            <label for="audio_url">URL Audio:</label>
            <input type="text" id="audio_url" name="audio_url">

            <label for="decouverte">Découverte:</label>
            <input type="checkbox" id="decouverte" name="decouverte">

            <label for="cdc">Coup de Coeur:</label>
            <input type="checkbox" id="cdc" name="cdc">

        <?php elseif ($type === 'concert'): ?>
            <!-- Form to add a concert -->
            <label for="photo">Photo:</label>
            <select id="photo" name="photo" onchange="previewImage()">
                <option value="">Sélectionner une photo</option>
                <?php
                if (isset($photos) && is_array($photos)) {
                    foreach ($photos as $photo): ?>
                        <option value="<?php echo htmlspecialchars(basename($photo)); ?>"><?php echo htmlspecialchars(basename($photo)); ?></option>
                    <?php endforeach;
                } else {
                    echo "<option value=''>Aucune photo disponible</option>";
                }
                ?>
            </select>

            <!-- Preview image -->
            <img id="imagePreview" class="image-preview" src="../images/next/<?php echo htmlspecialchars($data['photo']); ?>">

            <label for="groupe">Groupe:</label>
            <input type="text" id="groupe" name="groupe" required>

            <label for="lieux">Lieux:</label>
            <input type="text" id="lieux" name="lieux">
        <?php endif; ?>

        <button type="submit">Ajouter</button>
        <button type="button" onclick="window.history.back()">Annuler</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>