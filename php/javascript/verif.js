function validateForm() {
    const nomArtiste = document.getElementById('nom_artiste').value;
    const lienTitre = document.getElementById('lien_titre').value;
    const message = document.getElementById('message').value;
    
    // Artist name validation
    if (nomArtiste.length < 3 || nomArtiste.length > 255) {
        alert("Le nom de l'artiste doit avoir entre 3 et 255 caractères.");
        return false;
    }
    
    // Track link validation
    if (!/^https?:\/\/.+/.test(lienTitre)) {
        alert("Le lien vers le titre doit être une URL valide.");
        return false;
    }
    
    // Message validation (if not empty)
    if (message.length > 0 && (message.length < 10 || message.length > 2000)) {
        alert("Le message doit avoir entre 10 et 2000 caractères.");
        return false;
    }
    
    return true;
}

function validateForm() {
    var nom_artiste = document.getElementById('nom_artiste').value;
    if (nom_artiste.length < 3 || nom_artiste.length > 255) {
        alert('Le nom de l\'artiste doit avoir entre 3 et 255 caractères.');
        return false;
    }
    return true;
}