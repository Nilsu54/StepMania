<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> <!-- Define la codificación de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace que la página sea responsiva en dispositivos móviles -->
    <title>Selector de Canciones</title> <!-- Título que aparece en la pestaña del navegador -->
    <link rel="stylesheet" href="styles.css"> <!-- Enlaza la hoja de estilos CSS para dar formato a la página -->
    <link rel="icon" href="img/flecha.png" type="image/x-icon"> <!-- Enlaza un icono que aparece en la pestaña del navegador -->
</head>

<body>

    <div class="dropdown"> <!-- Contenedor para el menú desplegable de fondos -->
        <button class="dropbtn">Fondo</button> <!-- Botón que muestra el menú de selección de fondo -->
        <div class="dropdown-content"> <!-- Contenido del menú desplegable -->
            <a href="#" onclick="changeBackground('fondo1')">Fondo 1</a> <!-- Enlace que cambia el fondo a 'fondo1' -->
            <a href="#" onclick="changeBackground('fondo2')">Fondo 2</a> <!-- Enlace que cambia el fondo a 'fondo2' -->
            <a href="#" onclick="changeBackground('fondo3')">Fondo 3</a> <!-- Enlace que cambia el fondo a 'fondo3' -->
            <a href="#" onclick="changeBackground('fondo4')">Fondo 4</a> <!-- Enlace que cambia el fondo a 'fondo4' -->
            <a href="#" onclick="changeBackground('fondo5')">Fondo 5</a> <!-- Enlace que cambia el fondo a 'fondo5' -->
            <a href="#" onclick="changeBackground('fondo6')">Fondo 6</a> <!-- Enlace que cambia el fondo a 'fondo6' -->
            <a href="#" onclick="changeBackground('fondo7')">Fondo 7</a> <!-- Enlace que cambia el fondo a 'fondo7' -->
            <a href="#" onclick="changeBackground('fondo8')">Fondo 8</a> <!-- Enlace que cambia el fondo a 'fondo8' -->
            <a href="#" onclick="changeBackground('fondo9')">Fondo 9</a> <!-- Enlace que cambia el fondo a 'fondo9' -->
            <a href="#" onclick="changeBackground('fondo10')">Fondo 10</a> <!-- Enlace que cambia el fondo a 'fondo10' -->
        </div>
    </div>

    <div class="div-atras"> <!-- Contenedor para el botón de "Atrás" -->
        <button class="btn-back" onclick="window.location.href='index.html';"> <!-- Botón que redirige a 'index.html' -->
            Atrás
        </button>
    </div>

    <header class="header"> <!-- Cabecera de la página -->
        <h1 class="titulo-header">ELIGE UNA CANCIÓN</h1> <!-- Título principal de la aplicación -->
    </header>

    <div class="contenedor-bloques"> <!-- Contenedor para los bloques izquierdo y derecho -->
        <!-- Bloque de la izquierda que será actualizado dinámicamente -->
        <div class="bloque-izquierda">
            <div class="portada-cancion"> <!-- Contenedor para la portada de la canción -->
                <img id="img-portada" src="img/noimatge.jpg" alt="Portada Canción" class="img-portada"> <!-- Imagen de la portada -->
                <div class="info-cancion"> <!-- Contenedor para la información de la canción -->
                    <h2 id="titulo-cancion" class="titulo-cancion-grande">Seleciona Una cancion</h2> <!-- Título de la canción -->
                    <p id="artista-cancion" class="artista-cancion"></p> <!-- Nombre del artista (vacío al inicio) -->
                </div>
            </div>
        </div>

        <!-- Bloque derecho donde se listan las canciones -->
        <div class="bloque-derecha">
            <ul class="lista-canciones"> <!-- Lista que contendrá las canciones -->
                <!-- Aquí se agregarán las canciones dinámicamente con JavaScript -->
            </ul>
        </div>
    </div>

    <script src="javascript.js"></script> <!-- Enlaza el archivo JavaScript que contiene la lógica de la aplicación -->

    <footer>
        <div class="opciones-cancion"> <!-- Contenedor para las opciones de la canción -->
            <button class="btn-opcion">Jugar</button> <!-- Botón para iniciar el juego -->
            <button class="btn-opcion">Editar</button> <!-- Botón para editar la canción -->
            <button class="btn-opcion" onclick="eliminarCancion()">Eliminar</button> <!-- Botón para eliminar la canción -->
        </div>
    </footer>

    <script>
        // Variable para almacenar el objeto Audio que está reproduciéndose actualmente
        let currentAudio = null;

        // Leer canciones desde el archivo JSON y mostrarlas en la lista de la derecha
        fetch('data.json')
            .then(response => response.json()) // Convierte la respuesta en un objeto JSON
            .then(data => {
                // Ordenar las canciones por el título
                data.sort((a, b) => a.titulo_cancion.localeCompare(b.titulo_cancion)); // Ordena alfabéticamente

                const listaCanciones = document.querySelector('.lista-canciones'); // Selecciona el contenedor de la lista
                listaCanciones.innerHTML = ''; // Limpiar la lista antes de añadir canciones

                // Iterar sobre cada canción en el arreglo de datos
                data.forEach(cancion => {
                    // Crear un nuevo elemento <li> para cada canción
                    const li = document.createElement('li'); // Crea un nuevo elemento de lista
                    li.innerHTML = ` <!-- Contenido HTML del elemento de lista -->
                        <a href="javascript:void(0);" onclick="playSong('${cancion.Cancion}', '${cancion['Foto cancion']}', '${cancion.titulo_cancion}', '${cancion.Artista}')"> <!-- Enlace para reproducir la canción -->
                            <img src="uploads/${cancion['Foto cancion']}" alt="${cancion.titulo_cancion}" class="img-cancion"> <!-- Imagen de la canción -->
                            <span class="titulo-cancion">${cancion.titulo_cancion}</span> <!-- Título de la canción -->
                        </a>
                        <!-- Campo oculto para el nombre del artista -->
                        <input type="hidden" value="${cancion.Artista}"> <!-- Artista de la canción -->
                        <!-- Campo oculto para el archivo MP3 -->
                        <input type="hidden" value="${cancion.Cancion}"> <!-- Nombre del archivo de la canción -->
                    `;
                    listaCanciones.appendChild(li); // Agregar el nuevo elemento a la lista
                });
            });

        // Función para actualizar la caja de la izquierda y reproducir la canción
        function playSong(mp3File, imgFile, title, artist) {
            // Detener la canción actual si ya hay una reproduciéndose
            if (currentAudio) {
                currentAudio.pause(); // Pausa la canción actual
                currentAudio.currentTime = 0; // Reiniciar la canción
            }

            // Actualizar la imagen, título y artista en la caja izquierda
            document.getElementById('img-portada').src = `uploads/${imgFile}`; // Cambia la imagen de la portada
            document.getElementById('titulo-cancion').textContent = title; // Cambia el título de la canción
            document.getElementById('artista-cancion').textContent = `Artista: ${artist}`; // Cambia el nombre del artista

            // Reproducir la nueva canción
            currentAudio = new Audio(`uploads/${mp3File}`); // Crea un nuevo objeto Audio con el archivo MP3
            currentAudio.play(); // Reproduce la canción
        }
    </script>
    
</body>

</html>
