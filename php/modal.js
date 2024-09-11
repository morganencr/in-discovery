window.addEventListener('DOMContentLoaded', (event) => {
    var modal = document.getElementById('image-modal');
    var modalImg = document.getElementById('img-agrandie');
    var images = document.querySelectorAll('.img-caption img');
    var closeBtn = document.querySelector('.modal .close');

    images.forEach(function(img) {
        img.addEventListener('click', function() {
            console.log("Image cliquée:", this.src);
            modal.style.display = 'block';
            modalImg.src = this.src; 
        });
    });

    closeBtn.addEventListener('click', function() {
        console.log("Modal fermé");
        modal.style.display = 'none';
    });
});