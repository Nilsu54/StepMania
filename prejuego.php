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
            <a href="#" onclick="changeBackground('fondo1')">Fondo 1</a> 
            <a href="#" onclick="changeBackground('fondo2')">Fondo 2</a> 
            <a href="#" onclick="changeBackground('fondo3')">Fondo 3</a> 
            <a href="#" onclick="changeBackground('fondo4')">Fondo 4</a> 
            <a href="#" onclick="changeBackground('fondo5')">Fondo 5</a> 
            <a href="#" onclick="changeBackground('fondo6')">Fondo 6</a> 
            <a href="#" onclick="changeBackground('fondo7')">Fondo 7</a> 
            <a href="#" onclick="changeBackground('fondo8')">Fondo 8</a> 
            <a href="#" onclick="changeBackground('fondo9')">Fondo 9</a> 
            <a href="#" onclick="changeBackground('fondo10')">Fondo 10</a> 
        </div>
    </div>

    <div class="div-atras"> 
        <button class="btn-back" onclick="window.location.href='index.html';"> 
            Atrás
        </button>
    </div>

    <header class="header"> 
        <h1 class="titulo-header">ELIGE UNA CANCIÓN</h1> 
    </header>

    <div class="contenedor-bloques"> 
        <div class="bloque-izquierda">
            <div class="portada-cancion">
                <img id="img-portada" src="img/noimatge.jpg" alt="Portada Canción" class="img-portada">
                <div class="info-cancion">
                    <h2 id="titulo-cancion" class="titulo-cancion-grande">Selecciona Una Canción</h2>
                    <p id="artista-cancion" class="artista-cancion"></p>
                </div>
            </div>
        </div>

        <div class="bloque-derecha">
            <ul class="lista-canciones">
            </ul>
        </div>
    </div>

    <script src="javascript.js"></script>

    <footer>
        <div class="opciones-cancion"> 
            <button class="btn-opcion" onclick="iniciarJuego()">Jugar</button>
            <button class="btn-opcion" onclick="editarCancion()">Editar</button> 
            <button class="btn-opcion" onclick="eliminarCancion()">Eliminar</button> 
        </div>
        <div id="resultado-juego" class="resultado-juego">
            <!-- Aquí se mostrarán los resultados -->
        </div>

        <!-- Contenedor para mostrar las variables -->
        <div id="info-cancion-editada" style="margin-top: 20px;">
            <h3>Información de la Canción Editada:</h3>
            <p id="id-cancion-editada">ID: <span id="id-cancion-editada"></span></p>
            <p id="imagen-editada">Imagen: <span id="img-editada"></span></p>
            <p id="titulo-editado">Título: <span id="titulo-editado"></span></p>
            <p id="artista-editado">Artista: <span id="artista-editado"></span></p>
        </div>
    </footer>

    <script>
        let currentAudio = null;
        let imagenjuego = 'img/noimatge.jpg';  // Inicializar con la imagen predeterminada
        let titulojuego = '';   // Variable para almacenar el título de la canción
        let artistajuego = '';  // Variable para almacenar el artista de la canción
        let idCancion = '';     // Variable para almacenar el ID de la canción

        fetch('data.json')
            .then(response => response.json())
            .then(data => {
                data.sort((a, b) => a.titulo_cancion.localeCompare(b.titulo_cancion));
                const listaCanciones = document.querySelector('.lista-canciones');
                listaCanciones.innerHTML = '';

                data.forEach(cancion => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <a href="javascript:void(0);" onclick="selectSong('${cancion.Cancion}', '${cancion['Foto cancion']}', '${cancion.titulo_cancion}', '${cancion.Artista}', '${cancion.ID}')">
                            <img src="uploads/${cancion['Foto cancion']}" alt="${cancion.titulo_cancion}" class="img-cancion">
                            <span class="titulo-cancion">${cancion.titulo_cancion}</span>
                        </a>
                    `;
                    listaCanciones.appendChild(li);
                });
            });

        function selectSong(mp3File, imgFile, title, artist, id) {
            if (currentAudio) {
                currentAudio.pause();
                currentAudio.currentTime = 0;
            }

            // Actualizar la interfaz con la canción seleccionada
            document.getElementById('img-portada').src = `uploads/${imgFile}`;
            document.getElementById('titulo-cancion').textContent = title;
            document.getElementById('artista-cancion').textContent = `Artista: ${artist}`;

            // Guardar la información de la canción seleccionada en variables
            imagenjuego = `uploads/${imgFile}`; // Guardar la imagen seleccionada correctamente
            titulojuego = title; // Guardar el título de la canción
            artistajuego = artist; // Guardar el nombre del artista
            idCancion = id; // Guardar el ID de la canción

            // Iniciar la reproducción de la canción
            currentAudio = new Audio(`uploads/${mp3File}`);
            currentAudio.play();
        }

        function iniciarJuego() {
            // Verificar si la imagen es la predeterminada
            if (imagenjuego === 'img/noimatge.jpg') {
                alert('Tienes que seleccionar una imagen antes de jugar.');
                return; // No redirigir a juego.php
            }

            // Redirigir a juego.php y pasar variables a través de la URL
            window.location.href = `juego.php?imagenjuego=${encodeURIComponent(imagenjuego)}&titulojuego=${encodeURIComponent(titulojuego)}&artistajuego=${encodeURIComponent(artistajuego)}`;
        }

        function editarCancion() {
    // Verificar si la imagen es la predeterminada
    if (imagenjuego === 'img/noimatge.jpg') {
        alert('No se puede editar la canción porqueno has selecionado ninguna cancion.');
        return; // No redirigir a editform.php
    }

    // Redirigir a editform.php y pasar los datos de la canción a través de la URL
    window.location.href = `editform.php?id=${encodeURIComponent(idCancion)}&titulo_cancion=${encodeURIComponent(titulojuego)}&artista_cancion=${encodeURIComponent(artistajuego)}&foto_cancion=${encodeURIComponent(imagenjuego)}`;
}


    </script>
    
</body>

</html>
