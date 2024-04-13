function toggleMenu() {
    const ul = document.querySelector('ul');
    ul.classList.toggle('show');
}

window.addEventListener('resize', function () {
    const ul = document.querySelector('ul');
    if (window.innerWidth > 800) {
        ul.classList.remove('show');
    }
});
