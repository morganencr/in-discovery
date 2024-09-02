<?php
include_once '../connect.php'; // Chemin d'inclusion correct

// Sélectionnez tous les artistes qui correspondent aux genres "punk/rock" et "metal/hardcore"
$query = "SELECT * FROM artistes WHERE id_genre IN (SELECT id_genre FROM genres WHERE categorie IN ('punk/rock', 'metal/hardcore'))";
$result = $db->query($query); // Utilisation de $db

if ($result->rowCount() > 0) {
    echo "<table>";
    echo "<tr><th>Nom</th><th>Genre</th><th>Location</th><th>Découverte</th><th>Coup de Coeur</th><th>Actions</th></tr>";

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($row['id_genre']) . "</td>"; // Vous pouvez aussi afficher le genre sous forme de texte si vous le joignez dans la requête
        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
        echo "<td>" . ($row['decouverte'] ? 'Oui' : 'Non') . "</td>";
        echo "<td>" . ($row['cdc'] ? 'Oui' : 'Non') . "</td>";
        echo "<td>
                <button onclick=\"editConcert(" . $row['id_artiste'] . ")\">Ajouter</button>
                <button onclick=\"showForm('artiste', " . $row['id_artiste'] . ")\">Modifier</button>
                <button onclick=\"location.href='save.php?delete=" . $row['id_artiste'] . "&type=artiste'\">Supprimer</button>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Aucun artiste trouvé dans la catégorie Découvrir.";
}
?>