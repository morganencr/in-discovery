document.addEventListener('DOMContentLoaded', function() {
    const content = document.querySelector('#description-reseaux'); // Sélectionner le bon élément
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                content.classList.add('visible');
            }
        });
    }, { threshold: 0.2 });

    observer.observe(content);
});