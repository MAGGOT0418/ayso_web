document.getElementById('loginButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevenir redirección (ya no debería ser necesario, pero por si acaso)
    const modal = document.getElementById('loginModal');
    
    // Cargar el contenido del login dinámicamente
    fetch('login.html')
    .then(response => response.text())
    .then(data => {
        modal.innerHTML = data;
        modal.style.display = 'block'; // Mostrar el modal con el formulario

        // Script para cerrar el modal cuando se haga clic fuera de él
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    });
});