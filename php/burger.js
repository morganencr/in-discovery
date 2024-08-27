document.addEventListener("DOMContentLoaded", function() {
    const burgerMenu = document.getElementById('burger-menu');
    const burgerMenuContent = document.getElementById('burger-menu-content');

    burgerMenu.addEventListener('click', function() {
        if (burgerMenuContent.classList.contains('active')) {
            // si le menu est déjà actif, on commence par enlever l'animation
            burgerMenuContent.classList.remove('active');

            // attendre la fin de la transition pour cacher complètement le menu
            burgerMenuContent.addEventListener('transitionend', function handleTransitionEnd() {
                if (!burgerMenuContent.classList.contains('active')) {
                    burgerMenuContent.style.visibility = 'hidden';
                }
                // nettoyer l'événement pour éviter d'autres déclenchements
                burgerMenuContent.removeEventListener('transitionend', handleTransitionEnd);
            });
        } else {
            
            burgerMenuContent.style.visibility = 'visible';
            burgerMenuContent.classList.add('active');
        }
        console.log('Menu burger cliqué'); 
    });

    // fermer le menu bruger quand la taille de l'écran change
    window.addEventListener('resize', function() {
        
        const maxWidthForBurger = 768; 

        if (window.innerWidth > maxWidthForBurger && burgerMenuContent.classList.contains('active')) {
            
            burgerMenuContent.classList.remove('active');
            burgerMenuContent.style.visibility = 'hidden';
        }
    });
});