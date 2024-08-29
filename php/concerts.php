<?php
// Inclusion du fichier de connexion
require_once 'connect.php';

// Récupérer les informations des concerts
try {
    $stmt = $db->query('SELECT * FROM concerts');
    $concerts = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des concerts : " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="concerts.css"> 
    <title>Prochains Concerts</title>
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
                    <li><a href="concerts.php" class="nav-item">Les prochains concerts</a></li>
                    <li><a href="formulaire.php" class="nav-item">Suggestions</a></li>
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
                    <a href="concerts.php" class="dot dot2"><img src="images/icones/dot2.png" alt="Dot 2"></a>
                    
                <span class="dot-menu-item item3">Suggestions</span>
                    <a href="formulaire.php" class="dot dot3"><img src="images/icones/dot3.png" alt="Dot 3"></a>
            </div>
            </div>
            <div class="img-deco">
            <img src="images/punk-rock/muscle/muscle2.jpeg">
            </div>
        </div>
    </header>
    <main>
    <section class="concerts-container">
    <h1>:PROCHAINS. CONCERTS</h1>
            <?php foreach ($concerts as $concert): ?>
                    <td><img src="<?php echo htmlspecialchars($concert['photo']); ?>" alt="<?php echo htmlspecialchars($concert['groupe']); ?>" width="100"></td>
                    <td><?php echo htmlspecialchars($concert['groupe']); ?></td>
                    <td><?php echo htmlspecialchars($concert['lieux']); ?></td>
            <?php endforeach; ?>
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