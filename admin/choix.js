document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.getElementById("submit");
    const actionSelect = document.getElementById("action");
    const mangaNav = document.querySelector(".manga");
    const voteNav = document.querySelector(".vote");


    submitButton.addEventListener("click", function () {
        const selectedOption = actionSelect.value;
        if (selectedOption === "manga") {
            window.location.href = "admin_manga/admin_manga.php"; // Rediriger vers la page "admin_manga.php"
        } else if (selectedOption === "vote") {
            window.location.href = "admin_vote/admin_vote.php"; // Rediriger vers la page "admin_vote.php"
        } else if (selectedOption === "membres"){
            window.location.href = "membres/membres.php";
        }
    });

    actionSelect.addEventListener("change", function () {
        const selectedOption = actionSelect.value;
        if (selectedOption === "manga") {
            mangaNav.style.display = "block";
            voteNav.style.display = "none";
        } else if (selectedOption === "vote") {
            voteNav.style.display = "block";
            mangaNav.style.display = "none";
        }
    });
});
