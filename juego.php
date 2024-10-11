<?php
// Recuperar las variables de la URL utilizando el método GET
$imagenjuego = isset($_GET['imagenjuego']) ? $_GET['imagenjuego'] : 'img/noimatge.jpg';
$titulo_juego = isset($_GET['titulo_cancion']) ? $_GET['titulo_cancion'] : 'Título desconocido';
$artistajuego = isset($_GET['artistajuego']) ? $_GET['artistajuego'] : 'Artista desconocido';
$audiotrack = isset($_GET['audiofile']) ? $_GET['audiofile'] : '';

$usuario = '';
$puntuacion = '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STEPMANIA</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="img/flecha.png" type="image/x-icon">
    <script src="javascript.js"></script>
</head>

<body>

    <audio id="audio" controls autoplay style="display: none;">
        <source src="<?php echo htmlspecialchars($audiotrack); ?>" type="audio/mpeg">
        Tu navegador no soporta el elemento de audio.
    </audio>

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
        <button class="btn-back" onclick="window.location.href='prejuego.php';">Atrás</button>
    </div>

    <div class="contenedor-bloques">
        <div class="bloque-izquierdo">
            <p>
                <img class="imgjoc" src="<?php echo htmlspecialchars($imagenjuego); ?>" alt="<?php echo htmlspecialchars($titulo_juego); ?>" class="img-portada">
            </p>
            <p class="separar"><strong>Título:</strong> <?php echo htmlspecialchars($titulo_juego); ?></p>
            <p class="separar"><strong>Artista:</strong> <?php echo htmlspecialchars($artistajuego); ?></p>
        </div>
        <div class="bloque-central">
            <h1 class="titulo-joc">Gas al matalas</h1>
            <div class="bloque-de-flechas">
                <div class="bloque-flecha"><img class="flecha-dreta" src="/img/flecha-esquerra.jpg"></div>
                <div class="bloque-flecha"><img class="flecha-dreta" src="/img/flecha-adalt.jpg"> </div>
                <div class="bloque-flecha"> <img class="flecha-dreta" src="/img/flecha-abaix.jpg"></div>
                <div class="bloque-flecha"><img class="flecha-dreta" src="/img/flecha-dreta.jpg"> </div>
            </div>

            <div class="barra-progreso">
                <progress id="file" max="100" value="0">0%</progress>
                <span id="progress-text">0%</span>
            </div>
        </div>
        <div class="bloque-derecho">
            <span id="score-display">0 pts</span>
            <!-- Botón para mostrar el formulario -->
            <button class="save-score" id="save-score" style="display: none;" onclick="mostrarFormulario()">Guardar Puntuación</button>

            <!-- Formulario que se mostrará al pulsar el botón -->
            <div id="formulario" style="display: none;">
                <form method="post" id="puntuacion-form">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required><br>
                    <input type="hidden" id="puntuacion" name="puntuacion" value="0"><!-- Campo oculto para la puntuación -->
                    <button class="joc-enviar" type="submit">Enviar</button>
                </form>
                <div id="mensaje-confirmacion" style="display: none;"></div> <!-- Mensaje de confirmación -->
            </div>
        </div>
    </div>

    <script>
        function mostrarFormulario() {
            // Cambiar la visibilidad del formulario
            document.getElementById('formulario').style.display = 'block';
            // Ocultar el botón después de hacer clic
            document.getElementById('save-score').style.display = 'none';
        }

        const audio = document.getElementById('audio');

        audio.addEventListener('loadedmetadata', function() {
            const duration = audio.duration * 1000;
            updateProgress(duration);
        });

        function updateProgress(duration) {
            const progressBar = document.getElementById('file');
            const progressText = document.getElementById('progress-text');
            const scoreDisplay = document.getElementById('score-display');
            const saveButton = document.getElementById('save-score');
            const puntuacionInput = document.getElementById('puntuacion');

            let currentValue = 0;
            const increment = 100 / (duration / 100);

            function update() {
                if (currentValue < 100) {
                    currentValue += increment;
                    progressBar.value = currentValue;
                    progressText.textContent = Math.floor(currentValue) + '%';
                    setTimeout(update, 100);
                } else {
                    progressText.textContent = '100%';

                    // Generar puntuación aleatoria
                    const score = Math.floor(Math.random() * 100);
                    scoreDisplay.textContent = 'Puntuación: ' + score + ' pts';
                    
                    // Asignar la puntuación al campo oculto del formulario
                    puntuacionInput.value = score;

                    // Mostrar el botón de guardar
                    saveButton.style.display = 'block';
                }
            }
            update();
        }

        

            // Obtener el nombre y la puntuación
            const nombre = document.getElementById('nombre').value;
            const puntuacion = document.getElementById('puntuacion').value;

         

            // Ocultar el formulario
            document.getElementById('formulario').style.display = 'none';
        
    </script>
<?php 
// Inicializar las variables para el usuario y la puntuación


// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar y limpiar los datos
    $usuario = htmlspecialchars($_POST['nombre']);
    $puntuacion = htmlspecialchars($_POST['puntuacion']);
    
    // Aquí puedes hacer algo con los datos si lo necesitas, como guardarlos en una base de datos
    // Por ahora, simplemente se guardan en las variables.
     echo "Nombre: $usuario, Puntuación: $puntuacion"; // Solo para verificar
}   
?>
   

</body>

</html>
