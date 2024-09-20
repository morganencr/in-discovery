window.addEventListener('DOMContentLoaded', (event) => {
    var modal = document.getElementById('image-modal');
    var modalImg = document.getElementById('img-agrandie');
    var images = document.querySelectorAll('.img-caption img');
    var closeBtn = document.querySelector('.modal .close');
    var currentIndex = -1; 


    function showImage(index) {
        modal.style.display = 'block';
        modalImg.src = images[index].src;
        currentIndex = index; 
    }

    images.forEach(function(img, index) {
        img.addEventListener('click', function() {
            console.log("Image cliquée:", this.src);
            showImage(index);
        });

        img.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                showImage(index);
            }
        });
    });

    closeBtn.addEventListener('click', function() {
        console.log("Modal fermé");
        modal.style.display = 'none';
    });


    window.addEventListener('keydown', function(event) {
        if (modal.style.display === 'block') {
            if (event.key === 'ArrowRight') {
                if (currentIndex < images.length - 1) {
                    showImage(currentIndex + 1);
                }
            } else if (event.key === 'ArrowLeft') {
                if (currentIndex > 0) {
                    showImage(currentIndex - 1);
                }
            } else if (event.key === 'Escape') {
                modal.style.display = 'none';
            }
        }
    });
});