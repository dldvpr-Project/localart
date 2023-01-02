let modalDelete = document.getElementsByClassName('modalDelete');

window.onclick = function(event) {
    if (event.target == modalDelete) {
        modalDelete.style.display = "none";
    }
}