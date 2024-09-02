<?php
include_once '../connect.php'; // Assurez-vous que le chemin est correct

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

try {
    $sql = "SELECT * FROM artistes";
    $artists = $db->query($sql);

    if ($artists->rowCount() > 0) {
        while ($row = $artists->fetch(PDO::FETCH_ASSOC)) {
            // Assurez-vous que les clés existent avant d'appeler htmlspecialchars
            $nom = isset($row["nom"]) ? htmlspecialchars($row["nom"]) : 'Non spécifié';
            $genre = isset($row["genre"]) ? htmlspecialchars($row["genre"]) : 'Non spécifié';
            $location = isset($row["location"]) ? htmlspecialchars($row["location"]) : 'Non spécifié';
            $photo = isset($row["photo"]) ? 'images/' . htmlspecialchars($row["photo"]) : 'images/default.jpg'; // Chemin par défaut si la photo est manquante

            echo "<tr>
                    <td>{$nom}</td>
                    <td>{$genre}</td>
                    <td>{$location}</td>
                    <td><img src='{$photo}' alt='Photo de l'artiste' style='width: 100px; height: auto;'></td>
                    <td>
                        <button onclick=\"editArtist({$row['id_artiste']})\">Modifier</button>
                        <button onclick=\"deleteArtist({$row['id_artiste']})\">Supprimer</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Aucun artiste trouvé</td></tr>";
    }
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des artistes : " . $e->getMessage();
}
?>