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
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="artistes.css">
    <title><?php echo htmlspecialchars($artiste['nom']); ?> - IN:DISCOVERY</title>
</head>
<body>
<header>
        <div class="navbar">
            <nav class="nav-links">
                <div class="logo"><a href="index.php"><img src="Images/logodiscovery.png" alt="Logo IN:DISCOVERY."></a></div>
                <button class="burger-menu" id="burger-menu">
                    <img src="images/icones/menu-burger.png" alt="Menu Burger">
                </button>
                <div class="burger-menu-content" id="burger-menu-content">
                    <ul>
                    <li><a href="decouvrez.php" class="nav-item">Découvrir</a></li>
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
                <span class="dot-menu-item item1">Découvrir</span>
                    <a href="decouvrez.php" class="dot dot1"><img src="images/icones/dot1.png" alt="Dot 1"></a>
                    
                <span class="dot-menu-item item2">Les prochains concerts</span>
                    <a href="#" class="dot dot2"><img src="images/icones/dot2.png" alt="Dot 2"></a>
                    
                <span class="dot-menu-item item3">Suggestions</span>
                    <a href="#" class="dot dot3"><img src="images/icones/dot3.png" alt="Dot 3"></a>
            </div>
            </div>
            <div class="img-deco">
            <img src="images/punk-rock/muscle/muscle2.jpeg">
            </div>
        </div>
    </header>
    <main>
        <section id="artiste-details">
            <img src="<?php echo htmlspecialchars($artiste['photo']); ?>" alt="<?php echo htmlspecialchars($artiste['nom']); ?>">
            <h1><?php echo htmlspecialchars($artiste['nom']); ?></h1>
            <p><?php echo htmlspecialchars($artiste['genre']); ?></p>
            <p><?php echo htmlspecialchars($artiste['location']); ?></p>
            <p><?php echo htmlspecialchars($artiste['description']); ?></p>
            <p>Où les trouver : 
        <?php if (!empty($artiste['reseaux_sociaux'])): ?>
            <a href="<?php echo htmlspecialchars($artiste['reseaux_sociaux']); ?>" target="_blank">Suivez-les sur Instagram</a>
        <?php else: ?>
            Aucun lien Instagram disponible
        <?php endif; ?>
    </p>
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
    <script src="dots.js"></script>
</body>
</html>