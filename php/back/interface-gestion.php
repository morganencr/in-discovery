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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion de la Base de Données</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../images/logodiscovery.ico">
    <link rel="stylesheet" href="gestion.css">
</head>
<body>
    
    <div id="admin-interface">
        <h1>Interface de gestion</h1>
        
        <section id="section-artistes">
            <h2>Tous les Artistes/Groupes</h2>
            <button onclick="window.location.href='add.php?type=artiste'">Ajouter un Artiste/Groupe</button>
            <table id="artists-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'fetch_artists.php'; ?>
                </tbody>
            </table>
        </section>

        <section id="section-concerts">
            <h2>Prochains Concerts</h2>
            <button onclick="window.location.href='add.php?type=concert'">Ajouter un Concert</button>
            <table id="concerts-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Groupe</th>
                        <th>Lieux</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'fetch_concerts.php'; ?>
                </tbody>
            </table>
        </section>
        <section id="section-suggestions">
            <h2>Suggestions</h2>
            <button onclick="window.location.href='view_suggestions.php'">Voir les Suggestions</button>
        </section>

    <div id="management-form" style="display: none;">
        <form id="form-artiste-concert" method="POST" action="save.php">
            <input type="hidden" id="type" name="type">
            <input type="hidden" id="id" name="id">

            <div id="fields-artiste" style="display: none;">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>

                <label for="id_genre">Genre:</label>
                <select id="id_genre" name="id_genre" required>
                </select>

                <label for="location">Lieu:</label>
                <input type="text" id="location" name="location" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description"></textarea>

                <label for="photo">Photo URL:</label>
                <input type="text" id="photo" name="photo">

                <label for="reseaux_sociaux">Réseaux Sociaux:</label>
                <input type="text" id="reseaux_sociaux" name="reseaux_sociaux">

                <label for="audio_url">Audio URL:</label>
                <input type="text" id="audio_url" name="audio_url">

                <label for="decouverte">Découverte:</label>
                <input type="checkbox" id="decouverte" name="decouverte">

                <label for="cdc">Coup de Coeur:</label>
                <input type="checkbox" id="cdc" name="cdc">
            </div>

            <div id="fields-concert" style="display: none;">
                <label for="photo_concert">Photo URL:</label>
                <input type="text" id="photo_concert" name="photo">

                <label for="groupe">Groupe:</label>
                <input type="text" id="groupe" name="groupe" required>

                <label for="lieux">Lieux:</label>
                <input type="text" id="lieux" name="lieux" required>
            </div>

            <button type="submit">Sauvegarder</button>
            <button type="button" onclick="hideForm()">Annuler</button>
        </form>
    </div>
    <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
    </div>
    <script src="gestion.js" defer></script>
</body>
</html>