<?php
// Cargar los datos de las canciones desde el archivo JSON
$json = file_get_contents("data.json");
$Canciones = json_decode($json, true);

// Verificar si se pasó un ID para editar
$idCancion = $_GET['id'] ?? null; // Obtener el ID de la canción desde la URL
$cancionEditar = null; // Inicializar la variable

if ($idCancion) {
    // Buscar la canción que se quiere editar
    foreach ($Canciones as $cancion) {
        if ($cancion['ID'] === $idCancion) {
            $cancionEditar = $cancion;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="esp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Canción</title>
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
        <button class="btn-back" onclick="window.location.href='prejuego.php';">
            Atrás
        </button>
    </div>

    <div class="div-form2">
        <form action="editform.php?id=<?php echo $idCancion; ?>" method="POST" class="añadir-cancion-form" enctype="multipart/form-data">
            <label for="titulo_cancion">Título de la Canción:</label>
            <input type="text" id="titulo_cancion" name="titulo_cancion" required value="<?php echo htmlspecialchars($cancionEditar['titulo_cancion'] ?? ''); ?>">

            <label for="artista_cancion">Artista:</label>
            <input type="text" id="artista_cancion" name="artista_cancion" required value="<?php echo htmlspecialchars($cancionEditar['Artista'] ?? ''); ?>">

            <label for="arxivo_cancion">Archivo MP3:</label>
            <input type="file" id="arxivo_cancion" name="arxivo_cancion" accept=".mp3">
            <p>Archivo actual: <?php echo htmlspecialchars($cancionEditar['Cancion'] ?? 'Ninguno'); ?></p>

            <label for="foto_cancion">Subir Foto JPG:</label>
            <input class="btn-arx" type="file" id="foto_cancion" name="foto_cancion" accept=".jpg,.jpeg,.jfif">
            <p>Foto actual: <img src="uploads/<?php echo htmlspecialchars($cancionEditar['Foto cancion'] ?? 'noimage.jpg'); ?>" alt="Imagen Actual" style="width: 40px;"></p>

            <label for="txt_cancion">Archivo TXT:</label>
            <input type="file" id="txt_cancion" name="txt_cancion" accept=".txt">
            <p>Archivo TXT actual: <?php echo htmlspecialchars($cancionEditar['txt juego'] ?? 'Ninguno'); ?></p>

            <button type="submit" class="btn-enviar">EDITAR CANCIÓN</button>
        </form>
    </div>

    <?php
    // Procesar la edición de la canción si se envió el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Actualizar los datos de la canción
        $cancionActualizada = [
            "ID" => $idCancion,
            "titulo_cancion" => $_POST["titulo_cancion"],
            "Artista" => $_POST["artista_cancion"],
            "Foto cancion" => $_FILES["foto_cancion"]["name"] ?: $cancionEditar['Foto cancion'],
            "txt juego" => $_FILES["txt_cancion"]["name"] ?: $cancionEditar['txt juego'],
            "Cancion" => $_FILES["arxivo_cancion"]["name"] ?: $cancionEditar['Cancion']
        ];

        // Mover los archivos subidos si se proporcionaron nuevos
        if ($_FILES["foto_cancion"]["name"]) {
            move_uploaded_file($_FILES["foto_cancion"]["tmp_name"], "uploads/" . $cancionActualizada["Foto cancion"]);
        }
        if ($_FILES["txt_cancion"]["name"]) {
            move_uploaded_file($_FILES["txt_cancion"]["tmp_name"], "uploads/" . $cancionActualizada["txt juego"]);
        }
        if ($_FILES["arxivo_cancion"]["name"]) {
            move_uploaded_file($_FILES["arxivo_cancion"]["tmp_name"], "uploads/" . $cancionActualizada["Cancion"]);
        }

        // Actualizar la lista de canciones
        foreach ($Canciones as &$cancion) {
            if ($cancion['ID'] === $idCancion) {
                $cancion = $cancionActualizada; // Reemplazar con los nuevos datos
                break;
            }
        }

        // Guardar los datos actualizados en el archivo JSON
        $json = json_encode($Canciones, JSON_PRETTY_PRINT);
        file_put_contents("data.json", $json);

        // Redirigir a la página principal o mostrar un mensaje de éxito
        header("Location: index.html");
        exit();
    }
    ?>

    <script src="javascript.js"></script>
</body>
</html>
