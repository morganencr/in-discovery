<?php
require_once("connect.php");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Home page for IN:DISCOVERY. website">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <script>
        // Konami Code
        var konamiCode = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65];
        var konamiIndex = 0;

        document.addEventListener('keydown', function(event) {
            if (event.keyCode === konamiCode[konamiIndex]) {
                konamiIndex++;
                if (konamiIndex === konamiCode.length) {
                    // Redirect to admin interface
                    window.location.href = 'back/interface-gestion.php';
                }
            } else {
                konamiIndex = 0; // Reset the index if a key is incorrect
            }
        });
    </script>
    <title>IN:DISCOVERY.</title>
</head>

<body>
    <header>
        <div class="navbar">
            <nav class="nav-links">
                <div class="logo">
                    <a href="index.php"><img src="Images/logodiscovery.png" alt="Logo IN:DISCOVERY."></a>
                </div>
                <button class="burger-menu" id="burger-menu">
                    <img src="images/icones/menu-burger.png" alt="Menu Burger">
                </button>
                <div class="burger-menu-content" id="burger-menu-content">
                    <ul>
                        <li><a href="decouvrez.php" class="nav-item">Découvrir</a></li>
                        <li><a href="concerts.php" class="nav-item">Les prochains concerts</a></li>
                        <li><a href="formulaire.php" class="nav-item">Suggestions</a></li>
                        <li><a href="a-propos.php" class="nav-item">À propos</a></li>
                    </ul>
                </div>
                <a href="a-propos.php" id="nav-item">À propos</a>
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
                <img src="images/artistes/muscle2.jpeg" class="carousel-slide" alt="Muscle Mannschaft">
                <img src="images/artistes/foxholecarousel.jpeg" class="carousel-slide" alt="Foxhole">
                <img src="images/artistes/pathfindercarousel.jpg" class="carousel-slide" alt="Pathfinder">
                <img src="images/artistes/ivelearnedcarousel.jpg" class="carousel-slide" alt="I've Learned">
            </div>
        </div>
    </header>

    <main>
        <section id="cdc">
            <article id="cdc-container">
                <h2><span id="span-title">:</span>COUP DE COEUR<span id="span-title">.</span></h2>
                <figure id="cdc-content">
                    <?php
                    // Récupère les artistes pour la section Coup de Coeur
                    $sql = "SELECT id_artiste, nom, description, photo FROM artistes WHERE cdc = 1";
                    $stmt = $db->query($sql);

                    if (!$stmt) {
                        echo "Erreur SQL : " . implode(" ", $db->errorInfo());
                    }

                    if ($stmt->rowCount() > 0) {
                        // Affiche les données pour chaque artiste
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $photoPath = "../images/artistes/" . htmlspecialchars($row['photo']);
                            echo "<div class='artist'>
                                    <img src='" . $photoPath . "' alt='" . htmlspecialchars($row['nom']) . "'>
                                    <div class='caption'>
                                        <h3>" . htmlspecialchars($row['nom']) . "</h3>
                                        <div class='description'>
                                            <p>" . htmlspecialchars($row['description']) . "</p>
                                        </div>
                                        <a href='artistes.php?id=" . htmlspecialchars($row['id_artiste']) . "'>→ Voir la fiche artiste</a>
                                    </div>
                                  </div>";
                        }
                    } else {
                        echo "Aucun résultat";
                    }
                    ?>
                </figure>
            </article>
        </section>

        <section id="decouvrez">
            <article id="decouvrez-container">
                <h2><span id="span-title">:</span>DÉCOUVREZ<span id="span-title">.</span> nos groupes vedettes</h2>
                <figure id="decouvrez-content">
                    <?php
                    // Fetch the artists for the Favorites section
                    $sql2 = "SELECT id_artiste, nom, photo FROM artistes WHERE decouverte = 1";
                    $stmt2 = $db->query($sql2);

                    if (!$stmt2) {
                        echo "Erreur SQL : " . implode(" ", $db->errorInfo());
                        exit;
                    }

                    if ($stmt2->rowCount() > 0) {
                        // Display the data for each artist
                        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                            $photoPath = "../images/artistes/" . htmlspecialchars($row2['photo']);
                            echo "<div class='artist'>
                                    <div class='image-container'>
                                    <a href='artistes.php?id=" . htmlspecialchars($row2['id_artiste']) . "'>
                                        <img src='" . $photoPath . "' alt='" . htmlspecialchars($row2['nom']) . "'>
                                    </a>
                                    </div>
                                    <h3 class='groupes-decouverte'>" . htmlspecialchars($row2['nom']) . "</h3>
                                  </div>";
                        }
                    } else {
                        echo "Aucun résultat";
                    }
                    ?>
                </figure>
            </article>
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

    <script src="javascript/burger.js"></script>
    <script src="javascript/dots.js"></script>
    <script src="javascript/carousel.js"></script>
</body>

</html>