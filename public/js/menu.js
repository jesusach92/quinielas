// Obtén el menú de navegación
const navMenu = document.querySelector("nav ul");

// Agrega un manejador de eventos para mostrar/ocultar el menú en dispositivos móviles
document.querySelector(".w-28").addEventListener("click", () => {
    navMenu.classList.toggle("hidden");
});

// Agrega un manejador de eventos para ocultar el menú al hacer clic en un enlace (en dispositivos móviles)
navMenu.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => {
        navMenu.classList.add("hidden");
    });
});