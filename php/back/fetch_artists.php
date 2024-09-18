<?php
include_once '../connect.php';

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

try {
    $sql = "SELECT id_artiste, nom FROM artistes";
    $artists = $db->query($sql);

    if ($artists->rowCount() > 0) {
        while ($row = $artists->fetch(PDO::FETCH_ASSOC)) {
            $nom = htmlspecialchars($row["nom"]);
            echo "<tr>
                    <td>{$nom}</td>
                    <td>
                        <button onclick=\"window.location.href='modify.php?type=artiste&id={$row['id_artiste']}'\">Modifier</button>
                        <button onclick=\"deleteArtist({$row['id_artiste']})\">Supprimer</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='2'>Aucun artiste trouvé</td></tr>";
    }
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des artistes : " . $e->getMessage();
}
?>

<!-- Javascript for deletion -->
<script>
function deleteArtist(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet artiste ?")) {
        window.location.href = 'delete.php?type=artiste&id=' + id;
    }
}
</script>