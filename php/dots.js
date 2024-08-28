document.addEventListener('DOMContentLoaded', function() {
   
    const dots = document.querySelectorAll('.dot');
    
    dots.forEach(dot => {
        dot.addEventListener('mouseenter', function() {
            const previousSpan = this.previousElementSibling;
            if (previousSpan && previousSpan.classList.contains('dot-menu-item')) {
                previousSpan.style.color = getColorByClass(this.classList);
            }
        });
        
        // Ajoutez un événement 'mouseleave' pour réinitialiser la couleur
        dot.addEventListener('mouseleave', function() {
            const previousSpan = this.previousElementSibling;
            if (previousSpan && previousSpan.classList.contains('dot-menu-item')) {
                previousSpan.style.color = ''; 
            }
        });
    });
    

    function getColorByClass(classList) {
        if (classList.contains('dot1')) return '#D883AC';
        if (classList.contains('dot2')) return '#844865';
        if (classList.contains('dot3')) return '#EDC7D9';
        return 'white'; 
    }
});