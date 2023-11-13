// JavaScript pour gérer la navigation entre les groupes de mangas
let currentGroup = 0;

function showMangaGroup(groupIndex) {
    const mangaGroups = document.querySelectorAll('.manga-group');
    mangaGroups.forEach((group, index) => {
        group.style.display = index === groupIndex ? 'block' : 'none';
    });

    // Affichez le bouton "Suivant" uniquement si ce n'est pas le dernier groupe
    document.getElementById('nextButton').style.display = groupIndex < mangaGroups.length - 1 ? 'block' : 'none';

    // Affichez le bouton "Retour" uniquement si ce n'est pas le premier groupe
    document.getElementById('backButton').style.display = groupIndex > 0 ? 'block' : 'none';

    // Affichez le groupe de confirmation uniquement s'il s'agit du dernier groupe
    document.getElementById('confirmationGroup').style.display = groupIndex === mangaGroups.length - 1 ? 'block' : 'none';
}

function nextMangaGroup() {
    currentGroup += 1;
    showMangaGroup(currentGroup);
}

function backMangaGroup() {
    currentGroup -= 1;
    showMangaGroup(currentGroup);
}

// Fonction pour gérer la confirmation
function confirmVotes() {
    // Récupérez les réponses cochées par l'utilisateur
    const selectedMangas = document.querySelectorAll('input[name="manga"]:checked');
    const selectedMangaIds = Array.from(selectedMangas).map(input => input.value);

    // Envoyez les réponses à votre backend pour traitement (enregistrement des votes, par exemple)

    // Affichez un message de confirmation
    alert('Vos réponses ont été enregistrées avec succès !');
}

document.addEventListener('DOMContentLoaded', () => {
    showMangaGroup(currentGroup);
});