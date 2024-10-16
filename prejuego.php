<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_cancion'])) {
    // Obtener el ID de la canción desde el formulario
    $id = $_POST['id_cancion']; // No se necesita convertir a entero, ya que el ID es una cadena
    $jsonFile = 'data.json';  // Ruta del archivo JSON de canciones

    if (file_exists($jsonFile)) {
        $jsonData = json_decode(file_get_contents($jsonFile), true); // Decodificar el JSON

        if (!empty($jsonData)) {
            foreach ($jsonData as $index => $cancion) {
                // Comparar el ID de la canción
                if ($cancion['ID'] === $id) {
                    $archivoMP3 = 'uploads/songs/' . basename($cancion['Cancion']);
                    $archivoImagen = 'uploads/img/' . basename($cancion['Foto cancion']);

                    // Eliminar archivo MP3
                    if (file_exists($archivoMP3)) {
                        unlink($archivoMP3);
                    }

                    // Eliminar imagen
                    if (file_exists($archivoImagen)) {
                        unlink($archivoImagen);
                    }

                    // Eliminar la canción del array
                    unset($jsonData[$index]);

                    // Reindexar el array y guardar cambios en el JSON
                    $jsonData = array_values($jsonData);
                    file_put_contents($jsonFile, json_encode($jsonData, JSON_PRETTY_PRINT));

                    // Mensaje de éxito
                    echo json_encode(["status" => "success", "message" => "Canción y archivos eliminados correctamente"]);
                    exit();
                }
            }
        }
    }
    echo json_encode(["status" => "error", "message" => "No se encontró la canción con ese ID."]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selector de Canciones</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="img/flecha.png" type="image/x-icon">
</head>
<body>

    <div class="dropdown">
        <button class="dropbtn">Fondo</button>
        <div class="dropdown-content">
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

    <footer>
        <div class="opciones-cancion">
            <button class="btn-opcion" onclick="iniciarJuego()">Jugar</button>
            <button class="btn-opcion" onclick="editarCancion()">Editar</button>
            <button class="btn-opcion" onclick="eliminarCancion()">Eliminar</button>
        </div>
        <div id="resultado-juego" class="resultado-juego">
            <!-- Aquí se mostrarán los resultados -->
        </div>
    </footer>

    <script src="javascript.js"></script>

    <script>
        let currentAudio = null;
        let imagenjuego = 'img/noimatge.jpg';  // Inicializar con la imagen predeterminada
        let titulojuego = '';   // Variable para almacenar el título de la canción
        let artistajuego = '';  // Variable para almacenar el artista de la canción
        let idCancion = '';     // Variable para almacenar el ID de la canción
        let rutaAudio = '';     // Variable para almacenar la ruta del audio

        fetch('data.json', { cache: 'no-store' })
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
            rutaAudio = `uploads/${mp3File}`; // Guardar la ruta del audio

            // Iniciar la reproducción de la canción
            currentAudio = new Audio(rutaAudio); // Cargar el audio desde la ruta guardada
            currentAudio.play();
        }

        function eliminarCancion() {
            // Verificar si hay una canción seleccionada
            if (idCancion === '') {
                alert('No se ha seleccionado ninguna canción para eliminar.');
                return;
            }

            // Confirmación antes de eliminar
            const confirmDelete = confirm('¿Estás seguro de que deseas eliminar esta canción?');
            if (!confirmDelete) {
                return; // Si el usuario cancela, no hacer nada
            }

            // Enviar la solicitud POST para eliminar la canción
            const formData = new FormData();
            formData.append('id_cancion', idCancion);

            fetch('', { // Enviar a la misma página
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message); // Mostrar mensaje de éxito o error
                // Recargar la lista de canciones en la interfaz
                location.reload(); // Recargar la página para actualizar la lista
            })
            .catch(error => console.error('Error al eliminar la canción:', error));
        }

        function iniciarJuego() {
            // Verificar si la imagen es la predeterminada
            if (imagenjuego === 'img/noimatge.jpg') {
                alert('Tienes que seleccionar una imagen antes de jugar.');
                return; // No redirigir a juego.php
            }

            // Redirigir a juego.php y pasar variables a través de la URL
            window.location.href = `juego.php?imagenjuego=${encodeURIComponent(imagenjuego)}&titulo_cancion=${encodeURIComponent(titulojuego)}&artistajuego=${encodeURIComponent(artistajuego)}&audiofile=${encodeURIComponent(rutaAudio)}`; // Asegúrate de que el archivo de audio tenga la extensión correcta
        }

        function editarCancion() {
            // Verificar si la imagen es la predeterminada
            if (imagenjuego === 'img/noimatge.jpg') {
                alert('No se puede editar la canción porque no has seleccionado ninguna canción.');
                return; // No redirigir a editform.php
            }

            // Redirigir a editform.php y pasar los datos de la canción a través de la URL
            window.location.href = `editform.php?id=${encodeURIComponent(idCancion)}&titulo_cancion=${encodeURIComponent(titulojuego)}&artista_cancion=${encodeURIComponent(artistajuego)}&foto_cancion=${encodeURIComponent(imagenjuego)}`;
        }
    </script>

</body>
</html>
