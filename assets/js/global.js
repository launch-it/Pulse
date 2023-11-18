// Toggle sidebar collapse
document.getElementById('collapseToggle').addEventListener('click', function(event){
    event.preventDefault();
    if (window.innerWidth > 768) {
        var sidebar = document.getElementById('navbar');
        var toggleIcon = this.querySelector('i');
        var toggleText = this.childNodes[1];

        sidebar.classList.toggle('collapsed');

        if (sidebar.classList.contains('collapsed')) {
            toggleIcon.className = 'fas fa-angle-double-left';
        } else {
            toggleIcon.className = 'fas fa-angle-double-right';
            toggleText.nodeValue = 'Collapse Sidebar';
        }
    }
});