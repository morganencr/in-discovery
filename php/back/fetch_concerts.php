<?php
include_once '../connect.php'; // Assurez-vous que le chemin est correct

if (!$db) {
    die("Échec de la connexion à la base de données.");
}

try {
    $sql = "SELECT * FROM concerts";
    $concerts = $db->query($sql);

    if ($concerts->rowCount() > 0) {
        while($row = $concerts->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td><img src='" . htmlspecialchars($row["photo"]) . "' alt='Photo du concert' style='width: 100px; height: auto;'></td>
                    <td>" . htmlspecialchars($row["groupe"]) . "</td>
                    <td>" . htmlspecialchars($row["lieux"]) . "</td>
                    <td>
                            <button onclick=\"editConcert(" . $row['id_concert'] . ")\">Ajouter</button>
                            <button onclick=\"editConcert(" . $row['id_concert'] . ")\">Modifier</button>
                            <button onclick=\"deleteConcert(" . $row['id_concert'] . ")\">Supprimer</button>
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