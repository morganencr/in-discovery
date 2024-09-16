document.addEventListener("DOMContentLoaded", function() {
    const burgerMenu = document.getElementById('burger-menu');
    const burgerMenuContent = document.getElementById('burger-menu-content');

    burgerMenu.addEventListener('click', function() {
        burgerMenuContent.classList.toggle('active');
    });

    // fermer le menu burger quand la taille de l'écran change
    window.addEventListener('resize', function() {
        const maxWidthForBurger = 768;

        if (window.innerWidth > maxWidthForBurger && burgerMenuContent.classList.contains('active')) {
            burgerMenuContent.classList.remove('active');
        }
    });
});