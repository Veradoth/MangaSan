function showFields() {
    var selectedManga = document.getElementById('mangaSelect').value;
    var fields = document.querySelectorAll('.conditional-fields');
    
    if (selectedManga === '0') {
        for (var i = 0; i < fields.length; i++) {
            fields[i].style.display = 'none';
        }
    } else {
        for (var i = 0; i < fields.length; i++) {
            fields[i].style.display = 'block';
        }
    }
    // Stocker l'état des champs visibles dans le stockage local (localStorage)
    localStorage.setItem('fieldsVisible', selectedManga !== '0');
}

// Restaurer l'état des champs visibles lors du chargement de la page
window.onload = function() {
    var fieldsVisible = localStorage.getItem('fieldsVisible') === 'true';
    var fields = document.querySelectorAll('.conditional-fields');
    for (var i = 0; i < fields.length; i++) {
        fields[i].style.display = fieldsVisible ? 'block' : 'none';
    }
}