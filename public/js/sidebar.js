// Obtén todos los elementos de la lista del menú
const menuItems = document.querySelectorAll(".group li");

// Agrega un manejador de eventos a cada elemento para resaltar en el hover
menuItems.forEach((item) => {
    item.addEventListener("mouseover", () => {
        item.classList.add("bg-gray-200", "rounded","text-black", "delay-100","transition", "duration-300","px-1" ,"py-2", "mb-2");
    });

    item.addEventListener("mouseout", () => {
        item.classList.remove("bg-gray-200", "text-black", "transition","delay-100" ,"duration-300", "px-4","px-1", "py-2", "mb-2");
    });
});
