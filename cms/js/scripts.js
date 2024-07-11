document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.search-bar input');

    searchInput.addEventListener('keyup', function (event) {
        if (event.key === 'Enter') {
            const query = searchInput.value;
            window.location.href = `search.php?q=${query}`;
        }
    });
});
