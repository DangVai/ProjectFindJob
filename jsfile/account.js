document.addEventListener('DOMContentLoaded', function() {
    const accountIcon = document.querySelector('.account .fa-user');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    accountIcon.addEventListener('click', function() {
        dropdownMenu.classList.toggle('active');
    });

    document.addEventListener('click', function(event) {
        if (!accountIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove('active');
        }
    });
});