function changeBackground(fondo) {
    // Quitar clases de fondo existentes
    document.body.classList.remove('fondo1', 'fondo2', 'fondo3', 'fondo4', 'fondo5', 'fondo6', 'fondo7', 'fondo8', 'fondo9', 'fondo10');

    // Añadir la clase del fondo seleccionado
    document.body.classList.add(fondo);

    // Guardar el fondo seleccionado en localStorage
    localStorage.setItem('fondoSeleccionado', fondo);
}

// Función para aplicar el fondo guardado al cargar la página
function aplicarFondoGuardado() {
    const fondoGuardado = localStorage.getItem('fondoSeleccionado');
    if (fondoGuardado) {
        document.body.classList.add(fondoGuardado);
    } else {
        // Si no hay fondo guardado, establecer fondo por defecto
        document.body.classList.add('fondo1');
    }
}

// Llamar a la función al cargar la página
window.onload = aplicarFondoGuardado;

function playSong(mp3File) {
    console.log("Reproduciendo:", mp3File);
    const audio = new Audio(`uploads/${mp3File}`);
    audio.play();
}