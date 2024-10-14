<?php
// Ruta del archivo JSON
$jsonFile = 'puntuacion.json';

// Leer el contenido del archivo JSON
if (file_exists($jsonFile)) {
    $usuarios = json_decode(file_get_contents($jsonFile), true);
    // Asegúrate de que $usuarios sea un array
    if (!is_array($usuarios)) {
        $usuarios = [];
    }
} else {
    $usuarios = []; // Inicializar como array vacío si el archivo no existe
}

// Ordenar los usuarios por puntuación en orden descendente
usort($usuarios, function($a, $b) {
    return $b['puntuacion'] - $a['puntuacion'];
});

// Limitar a los 10 mejores jugadores
$topPlayers = array_slice($usuarios, 0, 10);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classificación</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="img/flecha.png" type="image/x-icon">
</head>

<body>
    <div>
        <h2 class="titulo-clas">CLASSIFICACIÓN</h2>
    </div>
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
    <div class="div-clas">
        <ul class="ul-clas">
            <?php
            // Generar la lista de jugadores
            foreach ($topPlayers as $index => $jugador) {
                // Mostrar solo hasta 10 jugadores
                echo '<li>
                        <span class="nombre-clas">Jugador ' . ($index + 1) . ': ' . htmlspecialchars($jugador['usuario']) . '</span>
                        <span class="pts-clas"> ' . htmlspecialchars($jugador['puntuacion']) . ' pts</span>
                      </li>';
            }

            // Rellenar hasta 10 si hay menos de 10 jugadores
            for ($i = count($topPlayers); $i < 10; $i++) {
                echo '<li>
                        <span class="nombre-clas">Jugador ' . ($i + 1) . ': --</span>
                        <span class="pts-clas"> 0 pts</span>
                      </li>';
            }
            ?>
        </ul>
    </div>

    <script src="javascript.js"></script>
</body>

</html>
