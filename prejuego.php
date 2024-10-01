<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selector de Canciones</title>
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
        <button class="btn-back" onclick="window.location.href='index.html';">
            Atrás
        </button>
    </div>
    <header class="header">
        <h1 class="titulo-header">ELIGE UNA CANCIÓN</h1>
    </header>
    <div class="contenedor-bloques">
        <div class="bloque-izquierda">

            <div class="portada-cancion">
                <img src="img/cancion1.jfif" alt="Portada Canción" class="img-portada">

                <div class="info-cancion">
                    <h2 class="titulo-cancion-grande">Molta Tralla</h2>
                    <p class="artista-cancion">Autista: Oques Grasses</p>
                </div>

            </div>


        </div>
        <div class="bloque bloque-derecha">
            <ul class="lista-canciones">
                

            </ul>
        </div>
    </div>

    <script src="javascript.js"></script>
    <footer>

        <div class="opciones-cancion">
            <button class="btn-opcion">Jugar</button>
            <button class="btn-opcion">Editar</button>
            <button class="btn-opcion">Eliminar</button>
        </div>

    </footer>

        <script>
// Leer canciones desde el archivo JSON y mostrarlas en la lista de la derecha
fetch('data.json')
    .then(response => response.json())
    .then(data => {
        const listaCanciones = document.querySelector('.lista-canciones');
        listaCanciones.innerHTML = '';  // Limpiar la lista antes de añadir canciones

        data.forEach(cancion => {
            // Crear un nuevo elemento <li> para cada canción
            const li = document.createElement('li');
            li.innerHTML = `
                <img src="uploads/${cancion['Foto cancion']}" alt="${cancion.titulo_cancion}" class="img-cancion">
                <span class="titulo-cancion">${cancion.titulo_cancion}</span>
            `;
            listaCanciones.appendChild(li);
        });
    })
    </script>
</body>

</html>