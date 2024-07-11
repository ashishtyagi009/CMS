document.addEventListener('DOMContentLoaded', function () {
    const deletePostLinks = document.querySelectorAll('.delete-post');
    deletePostLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            const confirmed = confirm('Are you sure you want to delete this post?');
            if (!confirmed) {
                event.preventDefault();
            }
        });
    });

    const deleteCommentLinks = document.querySelectorAll('.delete-comment');
    deleteCommentLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            const confirmed = confirm('Are you sure you want to delete this comment?');
            if (!confirmed) {
                event.preventDefault();
            }
        });
    });

    const editPostForm = document.querySelector('.admin-edit-post form');
    if (editPostForm) {
        editPostForm.addEventListener('submit', function (event) {
            const title = document.querySelector('input[name="title"]').value;
            const content = document.querySelector('textarea[name="content"]').value;

            if (title.trim() === '' || content.trim() === '') {
                alert('Both title and content are required.');
                event.preventDefault();
            }
        });
    }
});
