document.addEventListener("DOMContentLoaded", function() {
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        // Cambiar el tipo de input entre "password" y "text"
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // Alternar el ícono entre "fa-eye" y "fa-eye-slash"
        this.querySelector("i").classList.toggle("fa-eye");
        this.querySelector("i").classList.toggle("fa-eye-slash");

        // Añadir animación al ícono
        this.querySelector("i").classList.add("toggle-animation");
        setTimeout(() => {
            this.querySelector("i").classList.remove("toggle-animation");
        }, 300); // Tiempo de la animación
    });
});

