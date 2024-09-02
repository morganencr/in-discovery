<?php
include_once '../connect.php'; // Assurez-vous que le chemin est correct

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

// Récupération du type d'élément à ajouter
$type = $_GET['type'] ?? '';

// Récupérer les genres depuis la base de données
$genres = [];
try {
    $sql = "SELECT id_genre, genre FROM genres"; // Modifiez ici pour récupérer les colonnes correctes
    $stmt = $db->query($sql);
    $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des genres : " . $e->getMessage();
}

// Fonction pour récupérer les images depuis les sous-dossiers
function getImagesFromDirectory($directory) {
    $images = [];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Vérifie si le dossier existe
    if (is_dir($directory)) {
        // Crée un objet RecursiveDirectoryIterator pour parcourir récursivement le dossier
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        // Parcourt chaque fichier dans le dossier
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                // Récupère l'extension du fichier
                $extension = strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION));

                // Ajoute le fichier à la liste s'il a une extension autorisée
                if (in_array($extension, $allowedExtensions)) {
                    // Construire un chemin relatif depuis le dossier 'images'
                    $relativePath = str_replace(realpath($directory), '', realpath($file->getPathname()));
                    $relativePath = ltrim($relativePath, '/'); // Supprime le "/" initial pour un chemin relatif
                    $images[] = $relativePath;
                }
            }
        }
    }
    return $images;
}

// Utilisation de la fonction avec le chemin mis à jour
$directory = __DIR__ . '/../images'; // Chemin complet vers le dossier 'images' dans le dossier 'php'
$photos = getImagesFromDirectory($directory);

// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        try {
            if ($type === 'artiste') {
                $sql = "INSERT INTO artistes (nom, id_genre, location, description, photo, reseaux_sociaux, decouverte, cdc) VALUES (:nom, :id_genre, :location, :description, :photo, :reseaux_sociaux, :decouverte, :cdc)";
            } elseif ($type === 'decouverte') {
                $sql = "INSERT INTO decouvertes (nom, id_genre, location) VALUES (:nom, :id_genre, :location)";
            } elseif ($type === 'concert') {
                $sql = "INSERT INTO concerts (photo, groupe, lieux) VALUES (:photo, :groupe, :lieux)";
            }

            $stmt = $db->prepare($sql);
            $params = [
                ':nom' => $_POST['nom'] ?? '',
                ':id_genre' => $_POST['id_genre'] ?? '',
                ':location' => $_POST['location'] ?? '',
                ':description' => $_POST['description'] ?? '',
                ':photo' => $_POST['photo'] ?? '',
                ':reseaux_sociaux' => $_POST['reseaux_sociaux'] ?? '',
                ':decouverte' => isset($_POST['decouverte']) ? 1 : 0,
                ':cdc' => isset($_POST['cdc']) ? 1 : 0,
                ':groupe' => $_POST['groupe'] ?? '',
                ':lieux' => $_POST['lieux'] ?? ''
            ];
            $params = array_filter($params, function($v, $k) use ($sql) {
                return strpos($sql, $k) !== false;
            }, ARRAY_FILTER_USE_BOTH);

            $stmt->execute($params);

            // Rediriger vers la page de gestion après ajout
            header("Location: interface-gestion.php");
            exit;
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
    <title>Ajouter un élément</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Ajouter un <?php echo htmlspecialchars($type); ?></h1>

    <form method="POST" action="add.php?type=<?php echo htmlspecialchars($type); ?>">
        <input type="hidden" name="action" value="add">

        <?php if ($type === 'artiste'): ?>
            <!-- Formulaire pour ajouter un artiste -->
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

            <label for="photo">Photo:</label>
            <select id="photo" name="photo">
                <option value="">Sélectionner une photo</option>
                <?php foreach ($photos as $photo): ?>
                <option value="<?php echo htmlspecialchars($photo); ?>"><?php echo htmlspecialchars(basename($photo)); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="reseaux_sociaux">Réseaux Sociaux:</label>
            <input type="text" id="reseaux_sociaux" name="reseaux_sociaux">

            <label for="decouverte">Découverte:</label>
            <input type="checkbox" id="decouverte" name="decouverte">

            <label for="cdc">Coup de Coeur:</label>
            <input type="checkbox" id="cdc" name="cdc">

        <?php elseif ($type === 'decouverte'): ?>
            <!-- Formulaire pour ajouter une découverte -->
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

        <?php elseif ($type === 'concert'): ?>
            <!-- Formulaire pour ajouter un concert -->
            <label for="photo">Photo:</label>
            <select id="photo" name="photo">
                <option value="">Sélectionner une photo</option>
                <?php foreach ($photos as $photo): ?>
                    <option value="<?php echo htmlspecialchars(basename($photo)); ?>"><?php echo htmlspecialchars(basename($photo)); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="groupe">Groupe:</label>
            <input type="text" id="groupe" name="groupe" required>

            <label for="lieux">Lieux:</label>
            <input type="text" id="lieux" name="lieux">
        <?php endif; ?>

        <button type="submit">Ajouter</button>
        <button type="button" onclick="window.history.back()">Annuler</button>
    </form>
</body>
</html>