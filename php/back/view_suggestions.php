<?php
session_start();
include '../connect.php';

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

// Ajouter cette ligne pour définir l'encodage
$db->exec("SET NAMES 'utf8mb4'");

// Mettre à jour le nom de la colonne si elle est 'id_suggestion'
$sql = "SELECT id_suggestion, nom_artiste, lien_titre, message, date_suggestion FROM suggestions ORDER BY date_suggestion DESC";
$stmt = $db->query($sql);
$suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suggestions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="suggestions.css">
</head>
<body>
    <h1>Suggestions Soumises</h1>

    <?php
    // Afficher les messages de succès ou d'erreur
    if (isset($_SESSION['success'])) {
        echo "<p>{$_SESSION['success']}</p>";
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo "<p>$error</p>";
        }
        unset($_SESSION['errors']);
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Nom de l'Artiste</th>
                <th>Lien du Titre</th>
                <th>Message</th>
                <th>Date de Suggestion</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($suggestions as $suggestion): ?>
    <tr>
        <td><?php echo htmlspecialchars($suggestion['nom_artiste'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td>
            <?php
            $lien_titre = htmlspecialchars($suggestion['lien_titre'], ENT_QUOTES, 'UTF-8');
            if ($lien_titre) {
                echo '<a href="' . $lien_titre . '" target="_blank">' . $lien_titre . '</a>';
            } else {
                echo 'Aucun lien';
            }
            ?>
        </td>
        <td><?php echo htmlspecialchars($suggestion['message'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($suggestion['date_suggestion'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td>
            <form method="POST" action="delete_suggestion.php" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($suggestion['id_suggestion'], ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette suggestion ?');">Supprimer</button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>
        </tbody>
    </table>
    <a href="interface-gestion.php">Retour</a>
</body>
</html>