<?php
// Recuperar las variables de la URL
$imagenjuego = isset($_GET['imagenjuego']) ? $_GET['imagenjuego'] : 'img/noimatge.jpg'; // Valor por defecto
$titulojuego = isset($_GET['titulojuego']) ? $_GET['titulojuego'] : 'Título desconocido'; // Valor por defecto
$artistajuego = isset($_GET['artistajuego']) ? $_GET['artistajuego'] : 'Artista desconocido'; // Valor por defecto
?>

<!DOCTYPE html>
<html lang="en">

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
    <div class="div-atras"> <!-- Contenedor para el botón de "Atrás" -->
        <button class="btn-back" onclick="window.location.href='prejuego.php';"> <!-- Botón que redirige a 'prejuego.php' -->
            Atrás
        </button>
    </div>

    <div class="contenedor-bloques"> 
        <div class="bloque-izquierdo">
            <p> <img src="<?php echo htmlspecialchars($imagenjuego); ?>" alt="<?php echo htmlspecialchars($titulojuego); ?>" class="img-portada" ></p>
            <p><strong>Título:</strong> <?php echo htmlspecialchars($titulojuego); ?></p>
            <p><strong>Artista:</strong> <?php echo htmlspecialchars($artistajuego); ?></p>
        </div>
        <div class="bloque-central">
            <!-- Aquí puedes agregar contenido adicional -->
        </div>
        <div class="bloque-derecho">
            <a class> 0 pts</a>
        </div>
    </div>

</body>

</html>
