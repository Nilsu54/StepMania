<?php
// Recuperar las variables de la URL
$imagenjuego = isset($_GET['imagenjuego']) ? $_GET['imagenjuego'] : 'img/noimatge.jpg'; // Valor por defecto
$titulo_juego = isset($_GET['titulo_cancion']) ? $_GET['titulo_cancion'] : 'Título desconocido'; // Valor por defecto
$artistajuego = isset($_GET['artistajuego']) ? $_GET['artistajuego'] : 'Artista desconocido'; // Valor por defecto
$audiotrack = isset($_GET['audiofile']) ? $_GET['audiofile'] : ''; // Ruta del audio
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
    <button class="btn-back" onclick="window.location.href='prejuego.php';">
        Atrás
    </button>
</div>

<div class="contenedor-bloques"> 
    <div class="bloque-izquierdo">
        <p>
            <img class="imgjoc" src="<?php echo $imagenjuego ?>" alt="<?php echo htmlspecialchars($titulojuego); ?>" class="img-portada">
        </p>
        <p class="separar"><strong>Título:</strong> <?php echo htmlspecialchars($titulo_juego); ?></p>
        <p class="separar"><strong>Artista:</strong> <?php echo htmlspecialchars($artistajuego); ?></p>
    </div>
    <div class="bloque-central">
        <div class="barra-progreso">
            
            <progress id="file" max="100" value="0">0%</progress>
            <span id="progress-text">0%</span>
        </div>
    </div>
    <div class="bloque-derecho">
        <a class> 0 pts</a>
    </div>
</div>

<script>
    const audio = document.getElementById('audio'); // Solo una declaración

    // Escuchar el evento 'loadedmetadata' para obtener la duración en milisegundos
    audio.addEventListener('loadedmetadata', function() {
        const duration = audio.duration * 1000; // Duración total en milisegundos
        updateProgress(duration); // Iniciar la barra de progreso
    });

    function updateProgress(duration) {
        const progressBar = document.getElementById('file');
        const progressText = document.getElementById('progress-text');

        let currentValue = 0;
        const increment = 100 / (duration / 100); // Incremento en porcentaje cada intervalo

        function update() {
            if (currentValue < 100) {
                currentValue += increment; // Incrementa el valor
                progressBar.value = currentValue; // Actualiza el valor en la barra
                progressText.textContent = Math.floor(currentValue) + '%'; // Actualiza el texto del porcentaje
                setTimeout(update, 100); // Llama a la función nuevamente después de 100 ms
            } else {
                progressText.textContent = '100%'; // Asegúrate de mostrar 100% al final
            }
        }

        update(); // Comienza a actualizar la barra de progreso
    }
</script>

</body>
</html>
