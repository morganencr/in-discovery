<?php
include_once '../connect.php'; // Chemin d'inclusion correct

// Requête pour obtenir tous les artistes
$sql = "SELECT * FROM artistes";
$result = $db->query($sql); // Utilisation de $db

if ($result->rowCount() > 0) {
    // Afficher les données de chaque artiste
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($row["nom"]) . "</td>
                <td>" . htmlspecialchars($row["id_genre"]) . "</td>
                <td>" . htmlspecialchars($row["location"]) . "</td>
                <td>" . ($row["decouverte"] ? 'Oui' : 'Non') . "</td>
                <td>" . ($row["cdc"] ? 'Oui' : 'Non') . "</td>
                <td>
                    <button onclick=\"editConcert(" . $row['id_artiste'] . ")\">Ajouter</button>
                    <button onclick=\"editArtist(" . $row['id_artiste'] . ")\">Modifier</button>
                    <button onclick=\"deleteArtist(" . $row['id_artiste'] . ")\">Supprimer</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>Aucun artiste trouvé</td></tr>";
}
?>