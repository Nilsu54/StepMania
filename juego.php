<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STEPMANIA</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="img/flecha.png" type="image/x-icon">
</head>

<body>
<script src="javascript.js"></script>
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
        <button class="btn-back" onclick="window.location.href='index.html';"> <!-- Botón que redirige a 'index.html' -->
            Atrás
        </button>
    </div>

    <div class="contenedor-bloques"> 
      
        <div class="bloque-izquierdo">
            
        </div>
        <div class="bloque-central">

        </div>
        <div class="bloque-derecho">
           
        </div>
    </div>

</body>

</html>