<?php
include_once '../connect.php';

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

try {
    // Requête SQL avec jointure pour récupérer les noms des genres
    $sql = "
        SELECT a.*, g.genre AS genre_name
        FROM artistes a
        LEFT JOIN genres g ON a.id_genre = g.id_genre
    ";
    $artists = $db->query($sql);

    if ($artists->rowCount() > 0) {
        while ($row = $artists->fetch(PDO::FETCH_ASSOC)) {
            $nom = isset($row["nom"]) ? htmlspecialchars($row["nom"]) : 'Non spécifié';
            $genre = isset($row["genre_name"]) ? htmlspecialchars($row["genre_name"]) : 'Non spécifié';
            $location = isset($row["location"]) ? htmlspecialchars($row["location"]) : 'Non spécifié';
            $photo = isset($row["photo"]) ? '../images/artistes/' . htmlspecialchars($row["photo"]) : 'images/default.jpg';
            $photo2 = isset($row["photo2"]) ? '../images/artistes/' . htmlspecialchars($row["photo2"]) : 'images/default.jpg';
            $description = isset($row["description"]) ? htmlspecialchars($row["description"]) : 'Non spécifié';
            $reseaux_sociaux = isset($row["reseaux_sociaux"]) ? htmlspecialchars($row["reseaux_sociaux"]) : 'Non spécifié';
            $decouverte = isset($row["decouverte"]) && $row["decouverte"] ? 'Oui' : 'Non';
            $cdc = isset($row["cdc"]) && $row["cdc"] ? 'Oui' : 'Non';

            echo "<tr>
                    <td>{$nom}</td>
                    <td>{$genre}</td>
                    <td>{$location}</td>
                    <td><img src='{$photo}' alt='Photo de l\'artiste' style='width: 100px; height: auto;'></td>
                    <td><img src='{$photo2}' alt='Photo de l\'artiste' style='width: 100px; height: auto;'></td>
                    <td>{$description}</td>
                    <td>{$reseaux_sociaux}</td>
                    <td>{$decouverte}</td>
                    <td>{$cdc}</td>
                    <td>
                        <button onclick=\"window.location.href='modify.php?type=artiste&id={$row['id_artiste']}'\">Modifier</button>
                        <button onclick=\"deleteArtist({$row['id_artiste']})\">Supprimer</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='9'>Aucun artiste trouvé</td></tr>";
    }
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des artistes : " . $e->getMessage();
}
?>

<!-- Ajout de JavaScript pour la suppression -->
<script>
function deleteArtist(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet artiste ?")) {
        window.location.href = 'delete.php?type=artiste&id=' + id;
    }
}
</script>