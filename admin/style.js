document.addEventListener("DOMContentLoaded", function () {
    // Obtenez le chemin de la page actuelle
    var currentPagePath = window.location.pathname;

    // Masquez les liens en fonction de la page actuelle
    if (currentPagePath === "/admin_manga/admin_manga.php") {
        // Si vous êtes sur la page "page_manga.php", masquez les liens pour ajouter et modifier un vote
        document.querySelector("a[href='?action=add_vote']").style.display = "none";
    } else if (currentPagePath === "/admin_vote/admin_vote.php") {
        // Si vous êtes sur la page "page_vote.php", masquez les liens pour ajouter, modifier et supprimer un manga
        document.querySelector("a[href='?action=add_manga']").style.display = "none";
        document.querySelector("a[href='?action=mod_manga']").style.display = "none";
        document.querySelector("a[href='?action=suppr_manga']").style.display = "none";
    }
});