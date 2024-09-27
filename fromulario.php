<!DOCTYPE html>
<html lang="esp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Canción</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="img/flecha.png" type="image/x-icon">

</head>

<body>
    <header class="header">
        <h1 class="titulo-header">ELIGE UNA CANCIÓN</h1>
    </header>

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



    <div class="div-form">

        <form action="fromulario.php" method="POST" class="añadir-cancion-form">


            <label for="titulo_cancion">Título de la Canción:</label>
            <input type="text" id="titulo_cancion" name="titulo_cancion" required>

            <label for="artista_cancion">Artista:</label>
            <input type="text" id="artista_cancion" name="artista_cancion" required>


            <label for="arxivo_cancion">Archivo MP3:</label>
            <input type="file" id="arxivo_cancion" name="arxivo_cancion" required>

            <label for="foto_cancion">Subir Foto JPG</label>
            <input class="btn-arx" type="file" id="foto_cancion" name="foto_cancion" required>

            <label for="artista_cancion">Arxivo TXT:</label>
            <input type="file" id="txt_cancion" name="txt_cancion" required>

            <button type="submit" class="btn-enviar"> AÑADIR CANCION </button>
            <label for="artista_cancion"> </label>

        </form>

    </div>
   
    <script src="javascript.js"></script>
</body>

</html>