<?php
require_once("connect.php");
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
    <link rel="stylesheet" href="a-propos.css"> 
    <title>À Propos</title>
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
                <img src="images/artistes/muscle2.jpeg" class="carousel-slide">
                <img src="images/artistes/foxholecarousel.jpeg" class="carousel-slide">
                <img src="images/artistes/pathfindercarousel.jpg" class="carousel-slide">
                <img src="images/artistes/ivelearnedcarousel.jpg" class="carousel-slide">
            </div>
        </div>
    </header>
<body>
    <main>
        <section class="main-container">
            <h2><span>:</span>À PROPOS<span>.</span></h2>
            <article class="content">
                <figure id="content-1">
                    <h3><img src="images/icones/arrow-right-long-solid.svg"> QUI SOMMES-NOUS ?</h3>
                    <p><span class="website">IN:DISCOVERY.</span> est un concept né d'un mélange de créativité et d'envie de 
                        partager. À une époque où la consommation se veut rapide, simple et efficace,
                        il ne faut pas perdre de vue que derrière chaque produit consommé 
                        se cache un travail long et fastidieux. D'autant plus qu'aujourd'hui, avec les 
                        écarts sociaux qui se creusent au sein de notre société, il est important de mettre 
                        en lumière l'art des artistes au statu socio-professionnel toujours aussi 
                        précaire. Ce sont de ces artistes-là dont nous avions envie de porter le message, à large échelle,
                        pour qu'à leur tour ils puissent toucher un plus grand monde avec leur plume.
                        <br>
                        Ici, vous retrouverez des groupes et artistes issus de deux grandes scènes musicales :
                        le Punk-Rock et le Metal-Hardcore. Mais plus important encore, nous prenons soin de vous faire 
                        découvrir des groupes encore inconnus du grand public. 
                    </p>
                </figure>
                <figure id="content-2">
                    <h3><img src="images/icones/arrow-right-long-solid.svg"> POURQUOI EST-CE UN PROJET QUI NOUS TIENT À COEUR ?</h3>
                    <p>Ce projet est aussi dans le fond un projet collaboratif grâce à notre formulaire de 
                        suggestions par lequel vous pouvez nous envoyer vos propres découvertes. Nous ne tirons aucun bénéfice 
                        de ce site, à part celui de pouvoir partager et contribuer (peut-être) à l'acsension future de ces groupes.
                    </p>
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
    <script src="javascript/animation.js"></script>
</body>
</html>