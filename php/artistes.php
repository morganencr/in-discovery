<?php
require_once("connect.php");

// Test de connexion
if (!$db) {
    echo "Erreur de connexion à la base de données.";
    exit;
}

// Récupérer l'ID de l'artiste depuis l'URL
$artiste_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($artiste_id <= 0) {
    echo "ID d'artiste invalide.";
    exit;
}

// Préparer la requête SQL pour récupérer les détails de l'artiste avec son genre
$sql = "
    SELECT a.nom, a.description, a.photo, a.location, a.reseaux_sociaux, g.categorie, g.genre 
    FROM artistes a
    JOIN genres g ON a.id_genre = g.id_genre
    WHERE a.id_artiste = :id_artiste
";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id_artiste', $artiste_id, PDO::PARAM_INT);

if (!$stmt->execute()) {
    echo "Erreur SQL : " . implode(" ", $stmt->errorInfo());
    exit;
}

$artiste = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <title><?php echo htmlspecialchars($artiste['nom']); ?> - IN:DISCOVERY</title>
</head>
<body>
<header>
        <div class="navbar">
            <nav class="nav-links">
                <div class="logo"><a href="index.html"><img src="Images/logodiscovery.png" alt="Logo IN:DISCOVERY."></a></div>
                <button class="burger-menu" id="burger-menu">
                    <img src="images/icones/menu-burger.png" alt="Menu Burger">
                </button>
                <div class="burger-menu-content" id="burger-menu-content">
                    <ul>
                    <li><a href="#" class="nav-item">Découvrir</a></li>
                    <li><a href="#" class="nav-item">Les prochains concerts</a></li>
                    <li><a href="#" class="nav-item">Suggestions</a></li>
                    <li><a href="#" class="nav-item">À propos</a></li>
                    </ul>
                </div>
                <a href="#" id="nav-item">À propos</a>
            </nav>
        </div>
        <div class="side-menu">
            <div class="container-menu">
                <div class="menu-dots">
                    <a href="#" class="dot"><img src="images/icones/dot1.png" alt="Dot 1">
                        <span class="dot-menu-item">Découvrir</span></a>
                    <a href="#" class="dot"><img src="images/icones/dot2.png" alt="Dot 2">
                        <span class="dot-menu-item">Les prochains concerts</span></a>
                    <a href="#" class="dot"><img src="images/icones/dot3.png" alt="Dot 3">
                        <span class="dot-menu-item">Suggestions</span></a>
                </div>
            </div>
            <div class="img-bloc">
                <img src="images/punk-rock/first_draft/first_draft3.jpeg">
            </div>
        </div>
    </header>
    <main>
        <section id="artiste-details">
            <img src="<?php echo htmlspecialchars($artiste['photo']); ?>" alt="<?php echo htmlspecialchars($artiste['nom']); ?>">
            <h1><?php echo htmlspecialchars($artiste['nom']); ?></h1>
            <p><?php echo htmlspecialchars($artiste['genre']); ?></p>
            <p>Location: <?php echo htmlspecialchars($artiste['location']); ?></p>
            <p><?php echo htmlspecialchars($artiste['description']); ?></p>
            <p>Réseaux Sociaux: <?php echo htmlspecialchars($artiste['reseaux_sociaux']); ?></p>
        </section>
    </main>
    <footer>
        <div class="section-logo">
            <img src="images/logodiscovery.png" alt="Logo IN:DISCOVERY.">
        </div>
        <div class="section-contact">
            <p id="titre-contact">CONTACT</p>
            <p id="mail">contact.indiscovery@gmail.com</p>
            <div class="logos">
                <img src="images/icones/facebook.png" id="logo-fb">
                <img src="images/icones/Instagram_logo.png">
            </div>
        </div>
    </footer>
    <script src="burger.js"></script>
</body>
</html>