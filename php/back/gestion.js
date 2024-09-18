// Show the form to add or modify an artist or concert
function showForm(type, id = null) {
    document.getElementById('management-form').style.display = 'block';
    document.getElementById('type').value = type;

    if (type === 'artiste') {
        document.getElementById('fields-artiste').style.display = 'block';
        document.getElementById('fields-concert').style.display = 'none';
    } else if (type === 'concert') {
        document.getElementById('fields-artiste').style.display = 'none';
        document.getElementById('fields-concert').style.display = 'block';
    }

    if (id) {
        fetch(`fetch_${type}.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('id').value = id;
                for (let key in data) {
                    if (document.getElementById(key)) {
                        document.getElementById(key).value = data[key];
                    }
                }
            });
    } else {
        document.getElementById('form-artiste-concert').reset();
    }
}

// Hide management form
function hideForm() {
    document.getElementById('management-form').style.display = 'none';
}

// Delete an entity
function deleteEntity(type, id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
        fetch(`delete_${type}.php?id=${id}`, { method: 'POST' })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
    }
}