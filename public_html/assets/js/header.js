// JavaScript para alternar las barras al hacer clic en el botón de hamburguesa
function menu_vertical() {
    const burgerMenu = document.getElementById("burger-menu");
    const bar1 = document.getElementById("bar1");
    const bar2 = document.getElementById("bar2");
    const bar3 = document.getElementById("bar3");
    const nav = document.querySelector("nav");
    
    burgerMenu.addEventListener("click", function () {
        bar1.classList.toggle("change");
        bar2.classList.toggle("change");
        bar3.classList.toggle("change");
        nav.classList.toggle("active");
    });
    }