<!DOCTYPE html>
<html lang="esp">
<!-- Define el tipo de documento como HTML y establece el idioma a español -->

<head>
    <!-- Cabecera del documento con información sobre el documento -->
    <meta charset="UTF-8">
    <!-- Establece la codificación de caracteres a UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Asegura que el sitio sea responsivo en dispositivos móviles -->
    <title>Añadir Canción</title>
    <!-- Título de la página web que aparece en la pestaña del navegador -->
    <link rel="stylesheet" href="styles.css">
    <!-- Enlace a la hoja de estilos CSS externa -->
    <link rel="icon" href="img/flecha.png" type="image/x-icon">
    <!-- Favicon, el ícono que aparece en la pestaña del navegador -->
</head>

<body>
    <!-- Cuerpo del documento HTML -->

    <header class="header">
        <!-- Encabezado de la página -->
        <h1 class="titulo-header">ELIGE UNA CANCIÓN</h1>
        <!-- Título principal que aparece en la cabecera -->
    </header>

    <div class="dropdown">
        <!-- Menú desplegable para seleccionar fondos -->
        <button class="dropbtn">Fondo</button>
        <!-- Botón que activa el menú desplegable -->
        <div class="dropdown-content">
            <!-- Contenido del menú desplegable con enlaces -->
            <!-- Cada enlace cambia el fondo al seleccionar una opción -->
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
        <!-- Fin del contenido del menú desplegable -->
    </div>

    <div class="div-atras">
        <!-- Div que contiene un botón para volver a la página principal -->
        <button class="btn-back" onclick="window.location.href='index.html';">
            Atrás
        </button>
        <!-- Botón que redirige a la página "index.html" -->
    </div>

    <div class="div-form">
        <!-- Div que contiene el formulario para añadir una canción -->
        <form action="fromulario.php" method="POST" class="añadir-cancion-form" enctype="multipart/form-data">
            <!-- Formulario con método POST para enviar los datos a un archivo PHP -->
            <!-- "enctype" se utiliza para permitir la subida de archivos -->

            <label for="titulo_cancion">Título de la Canción:</label>
            <!-- Etiqueta para el campo del título de la canción -->
            <input type="text" id="titulo_cancion" name="titulo_cancion" required>
            <!-- Campo de texto obligatorio para ingresar el título de la canción -->

            <label for="artista_cancion">Artista:</label>
            <!-- Etiqueta para el campo del artista -->
            <input type="text" id="artista_cancion" name="artista_cancion" required>
            <!-- Campo de texto obligatorio para ingresar el nombre del artista -->

            <label for="arxivo_cancion">Archivo MP3:</label>
            <!-- Etiqueta para el campo de subida de archivo MP3 -->
            <input type="file" id="arxivo_cancion" name="arxivo_cancion" accept=".mp3" required>
            <!-- Campo para subir un archivo de tipo MP3 -->

            <label for="foto_cancion">Subir Foto JPG:</label>
            <!-- Etiqueta para el campo de subida de imagen -->
            <input class="btn-arx" type="file" id="foto_cancion" name="foto_cancion" accept=".jpg,.jpeg,.jfif,." required>
            <!-- Campo para subir una imagen de formato JPG/JPEG/JFIF -->

            <label for="txt_cancion">Archivo TXT:</label>
            <!-- Etiqueta para el campo de subida de archivo TXT -->
            <input type="file" id="txt_cancion" name="txt_cancion" accept=".txt" required>
            <!-- Campo para subir un archivo de texto plano (TXT) -->
            <label for="txt_cancion">TXT:</label>
            <textarea id="comentarios" name="comentarios" rows="4" cols="50">
Escribe el arxivo de juego aqui
                </textarea>


                <button type="submit" class="btn-enviar">AÑADIR CANCIÓN</button>
                <!-- Botón para enviar el formulario -->
        </form>
    </div>

    <script src="javascript.js"></script>
    <!-- Enlace a un archivo JavaScript externo para las funcionalidades de la página -->
</body>

</html>

<?php
// Comienza el bloque PHP fuera del HTML

// Leer el contenido existente del archivo JSON
$json = file_get_contents("data.json");
// Decodifica el contenido del archivo JSON en un array asociativo de PHP
$Cançons = json_decode($json, true);

// Crear la carpeta "uploads" si no existe
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
    // Si la carpeta "uploads" no existe, la crea con permisos completos (0777)
}

// Guardar los nombres de los archivos subidos
$arxivo_cancion = $_FILES["arxivo_cancion"]["name"];
$foto_cancion = $_FILES["foto_cancion"]["name"];
$txt_cancion = $_FILES["txt_cancion"]["name"];
// Asigna los nombres de los archivos subidos al array $_FILES a variables

// Mover los archivos subidos a la carpeta "uploads"
if (
    move_uploaded_file($_FILES["foto_cancion"]["tmp_name"], "uploads/" . $foto_cancion) &&
    move_uploaded_file($_FILES["txt_cancion"]["tmp_name"], "uploads/" . $txt_cancion) &&
    move_uploaded_file($_FILES["arxivo_cancion"]["tmp_name"], "uploads/" . $arxivo_cancion)
) {

    // Si los archivos se mueven correctamente a la carpeta "uploads", continúa
    // Crear un nuevo array con los datos del formulario
    $Canço = [
        "ID"=> uniqid(prefix: number_format(true)),
        "titulo_cancion" => $_POST["titulo_cancion"], // Almacena el título de la canción
        "Artista" => $_POST["artista_cancion"],       // Almacena el nombre del artista
        "Foto cancion" => $foto_cancion,              // Almacena el nombre del archivo de la foto
        "txt juego" => $txt_cancion,                  // Almacena el nombre del archivo de texto
        "Cancion" => $arxivo_cancion                  // Almacena el nombre del archivo MP3
    ];

    // Añadir la nueva canción al array de canciones
    $Cançons[] = $Canço;

    // Convertir el array de canciones actualizado a formato JSON
    $json = json_encode($Cançons, JSON_PRETTY_PRINT);
    // Guardar el nuevo contenido JSON en el archivo "data.json"
    file_put_contents("data.json", $json);
} else {
    // Si hubo un error al mover los archivos, muestra un mensaje de error
    echo "Error al mover los archivos.";
}
?>