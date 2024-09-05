<?php
include_once '../connect.php';

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

try {
    $sql = "SELECT * FROM concerts";
    $concerts = $db->query($sql);

    if ($concerts->rowCount() > 0) {
        while($row = $concerts->fetch(PDO::FETCH_ASSOC)) {
            $photoPath = '../images/next/' . htmlspecialchars($row["photo"]); // Concaténer correctement le chemin
            echo "<tr>
                    <td><img src='" . $photoPath . "' alt='Photo du concert' style='width: 100px; height: auto;'></td>
                    <td>" . htmlspecialchars($row["groupe"]) . "</td>
                    <td>" . htmlspecialchars($row["lieux"]) . "</td>
                    <td>
                        <button onclick=\"window.location.href='modify.php?type=concert&id={$row['id_concert']}'\">Modifier</button>
                        <button onclick=\"deleteConcert({$row['id_concert']})\">Supprimer</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Aucun concert trouvé</td></tr>";
    }
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des concerts : " . $e->getMessage();
}
?>

<!-- Ajout de JavaScript pour la suppression -->
<script>
function deleteConcert(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce concert ?")) {
        window.location.href = 'delete.php?type=concert&id=' + id;
    }
}
</script>