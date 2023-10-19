document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.getElementById("submit");
    const actionSelect = document.getElementById("action");

    submitButton.addEventListener("click", function () {
        const selectedOption = actionSelect.value;
        if (selectedOption === "manga") {
            // Rediriger vers la page Manga
            window.location.href = "admin_manga/admin_manga.php";
        } else if (selectedOption === "vote") {
            // Rediriger vers la page Vote
            window.location.href = "admin_vote/admin_vote.php";
        }
    });
});
