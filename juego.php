<?php

// Recuperar las variables de la URL utilizando el método GET
$imagenjuego = isset($_GET['imagenjuego']) ? htmlspecialchars($_GET['imagenjuego']) : 'img/noimatge.jpg';
$titulo_juego = isset($_GET['titulo_cancion']) ? htmlspecialchars($_GET['titulo_cancion']) : 'Título desconocido';
$artistajuego = isset($_GET['artistajuego']) ? htmlspecialchars($_GET['artistajuego']) : 'Artista desconocido';
$audiotrack = isset($_GET['audiofile']) ? htmlspecialchars($_GET['audiofile']) : '';

$usuario = '';
$puntuacion = '';

// Inicializar las variables para el usuario y la puntuación
$jsonFile = 'puntuacion.json';

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar y limpiar los datos
    $usuario = htmlspecialchars($_POST['nombre']);
    $puntuacion = htmlspecialchars($_POST['puntuacion']);

    // Asegúrate de que la puntuación es un número válido
    if (!is_numeric($puntuacion) || intval($puntuacion) < 0) {
        // Si la puntuación no es válida, puedes manejarlo aquí, por ejemplo, mostrar un error
        echo "<script>alert('Puntuación no válida. Debe ser un número positivo.'); window.history.back();</script>";
        exit();
    }

    // Generar un nombre único para la cookie
    $cookieName = 'puntuacion_' . time(); // Ejemplo: puntuacion_1635403450
    setcookie($cookieName, $puntuacion, time() + (86400 * 30), "/"); // La cookie durará 30 días

    // Cargar el archivo JSON de usuarios
    if (file_exists($jsonFile)) {
        $usuarios = json_decode(file_get_contents($jsonFile), true);
        // Asegurarse de que $usuarios sea un array
        if (!is_array($usuarios)) {
            $usuarios = [];
        }
    } else {
        $usuarios = []; // Inicializar como array vacío si el archivo no existe
    }

    // Verificar si el usuario ya existe en el archivo JSON
    $usuarioExistente = false;
    foreach ($usuarios as &$user) {
        if ($user['usuario'] === $usuario) {
            $usuarioExistente = true;
            // Actualizar los datos del usuario existente
            $user['ultima_entrada'] = date('Y-m-d H:i:s');
            $user['puntuacion'] += intval($puntuacion); // Sumar la puntuación
            break;
        }
    }

    // Si el usuario no existe, agregarlo
    if (!$usuarioExistente) {
        $nuevoUsuario = [
            'usuario' => $usuario,
            'puntuacion' => intval($puntuacion),
            'ultima_entrada' => date('Y-m-d H:i:s')
        ];
        $usuarios[] = $nuevoUsuario;
    }

    // Guardar los cambios en el archivo JSON
    if (file_put_contents($jsonFile, json_encode($usuarios, JSON_PRETTY_PRINT)) === false) {
        echo "<script>alert('Error al guardar la puntuación. Inténtalo de nuevo.'); window.history.back();</script>";
        exit();
    }

    // Redirigir a clasificación.php
    header('Location: Classificación.php');
    exit(); // Asegurarse de que no se ejecute más código después de la redirección
}
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
        <button class="btn-back" onclick="confirmarSalida()">Atrás</button>
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
            <h1 class="titulo-joc">¡Joel supera a tu ex!</h1>
            <div class="bloque-de-flechas">
                <div class="bloque-flecha"><img  class="flecha-esquerra" src="/img/flecha-esquerra.jpg"></div>
                <div class="bloque-flecha"><img class="flecha-adalt" src="/img/flecha-adalt.jpg"></div>
                <div class="bloque-flecha"><img class="flecha-abaix" src="/img/flecha-abaix.jpg"></div>
                <div class="bloque-flecha"><img class="flecha-dreta" src="/img/flecha-dreta.jpg"></div>
            </div>

            <div class="barra-progreso">
                <progress id="file" max="100" value="0">0%</progress>
                <span id="progress-text">0%</span>
            </div>
        </div>
        <div class="bloque-derecho">
        <audio id="audio" controls autoplay style="display: none ">
        <source src="<?php echo htmlspecialchars($audiotrack); ?>" type="audio/mpeg">
        Tu navegador no soporta el elemento de audio.
    </audio>
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

let flechas = document.querySelectorAll('.flecha-dreta, .flecha-adalt, .flecha-abaix, .flecha-esquerra');
let flechaVisible = null; // Para rastrear la flecha actualmente visible
let score = 0;
let flechaInterval; // Variable para el intervalo de las flechas

function restapunts() {
    score = score - 50;
    document.getElementById('score-display').textContent = score + ' pts'; // Actualiza el display
}

function sumapunts() {
    score = score + 100;
    document.getElementById('score-display').textContent = score + ' pts'; // Actualiza el display
}

function mostrarFlechasAleatoriamente() {
    // Ocultar todas las flechas primero
    flechas.forEach(flecha => {
        flecha.style.display = 'none'; // Oculta todas las flechas
    });

    // Seleccionar un índice aleatorio para mostrar una flecha
    const randomIndex = Math.floor(Math.random() * flechas.length);
    
    // Mostrar la flecha seleccionada
    flechas[randomIndex].style.display = 'block'; // Muestra solo una flecha
    flechaVisible = flechas[randomIndex]; // Actualiza la flecha visible

    // Ocultar la flecha después de 2 segundos
    setTimeout(() => {
        flechaVisible.style.display = 'none'; // Oculta la flecha
        flechaVisible = null; // Resetea la flecha visible
    }, 350); // Cambia el tiempo a 400 ms 
}

// Llamar a la función cada 1 segundos para que haya un intervalo entre la aparición y desaparición
flechaInterval = setInterval(mostrarFlechasAleatoriamente, 1000); // Cambia cada 1 segundos

document.addEventListener('keydown', (event) => {
    // Detectar "d" o "D" para ocultar flecha-dreta
    if ((event.key === 'd' || event.key === 'D') && flechaVisible && flechaVisible.classList.contains('flecha-dreta')) {
        flechaVisible.style.display = 'none'; // Oculta la flecha visible
        flechaVisible = null; // Resetea la flecha visible
        sumapunts();
    }
    if ((event.key === 'a' || event.key === 'A') && flechaVisible && flechaVisible.classList.contains('flecha-esquerra')) {
        flechaVisible.style.display = 'none'; // Oculta la flecha visible
        flechaVisible = null; // Resetea la flecha visible
        sumapunts();
    }
    if ((event.key === 'w' || event.key === 'W') && flechaVisible && flechaVisible.classList.contains('flecha-adalt')) {
        flechaVisible.style.display = 'none'; // Oculta la flecha visible
        flechaVisible = null; // Resetea la flecha visible
        sumapunts();
    }
    if ((event.key === 's' || event.key === 'S') && flechaVisible && flechaVisible.classList.contains('flecha-abaix')) {
        flechaVisible.style.display = 'none'; // Oculta la flecha visible
        flechaVisible = null; // Resetea la flecha visible
        sumapunts();
    }
    if ((event.key === 's' || event.key === 'S' || event.key === 'a' || event.key === 'A' || event.key === 'w' || event.key === 'W' || event.key === 'd' || event.key === 'D')) {
        flechaVisible.style.display = 'none'; // Oculta la flecha visible
        flechaVisible = null; // Resetea la flecha visible
        restapunts();
    }
});

function mostrarFormulario() {
    // Cambiar la visibilidad del formulario
    document.getElementById('formulario').style.display = 'block';
    // Ocultar el botón después de hacer clic
    document.getElementById('save-score').style.display = 'none';
}

function confirmarSalida() {
    if (confirm("¿Estás seguro de que deseas volver atrás?")) {
        window.location.href = 'prejuego.php';
    }
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

            // Detener la aparición de flechas al llegar al 100%
            clearInterval(flechaInterval); // Detener el intervalo de las flechas

            // Asignar la puntuación al campo oculto del formulario
            puntuacionInput.value = score;
            console.log('Puntuación enviada:', score); // Verificar valor
            // Mostrar el botón de guardar
            saveButton.style.display = 'block';
        }
    }
    update();
}

    </script>

</body>

