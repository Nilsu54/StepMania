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
    <form action="fromulario.php" method="POST" class="añadir-cancion-form" enctype="multipart/form-data">
    <label for="titulo_cancion">Título de la Canción:</label>
    <input type="text" id="titulo_cancion" name="titulo_cancion" required>

    <label for="artista_cancion">Artista:</label>
    <input type="text" id="artista_cancion" name="artista_cancion" required>

    <label for="arxivo_cancion">Archivo MP3:</label>
    <input type="file" id="arxivo_cancion" name="arxivo_cancion" accept=".mp3" required>

    <label for="foto_cancion">Subir Foto JPG:</label>
    <input class="btn-arx" type="file" id="foto_cancion" name="foto_cancion" accept=".jpg,.jpeg,.jfif" required>

    <label for="txt_cancion">Archivo TXT:</label>
    <input type="file" id="txt_cancion" name="txt_cancion" accept=".txt" required>

    <button type="submit" class="btn-enviar">AÑADIR CANCIÓN</button>
</form>
    </div>
   
    <script src="javascript.js"></script>
</body>

</html>

<?php
// Comienza el bloque PHP fuera del HTML

// Leer el contenido existente del archivo JSON
$json = file_get_contents("data.json");
$Cançons = json_decode($json, true);

// Crear la carpeta "uploads" si no existe
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

// Guardar los nombres de los archivos
$arxivo_cancion = $_FILES["arxivo_cancion"]["name"];
$foto_cancion = $_FILES["foto_cancion"]["name"];
$txt_cancion = $_FILES["txt_cancion"]["name"];


// Mover los archivos subidos a la carpeta "uploads"
if (move_uploaded_file($_FILES["foto_cancion"]["tmp_name"], "uploads/" . $foto_cancion) &&
    move_uploaded_file($_FILES["txt_cancion"]["tmp_name"], "uploads/" . $txt_cancion) &&
    move_uploaded_file($_FILES["arxivo_cancion"]["tmp_name"], "uploads/" . $arxivo_cancion)) {

    // Crear un nuevo array con los datos del formulario
    $Canço = [
        "titulo_cancion" => $_POST["titulo_cancion"], 
        "Artista" => $_POST["artista_cancion"],   
        "Foto cancion" => $foto_cancion,  // Guardar el nombre del archivo
        "txt juego" => $txt_cancion,       // Guardar el nombre del archivo
        "Cancion" => $arxivo_cancion       // Guardar el nombre del archivo     

        
    ];

    // Añadir la nueva canción al array de canciones
    $Cançons[] = $Canço;

    // Convertir el array a formato JSON y guardarlo
    $json = json_encode($Cançons, JSON_PRETTY_PRINT);
    file_put_contents("data.json", $json);
} else {
    echo "Error al mover los archivos.";
}
?>
