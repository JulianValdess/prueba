<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JE Videogames</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    <header>
        <h1 class="titulo">JE Videogames <span> & more</span></h1>
    </header>

    <div class="nav-bg">
        <nav class="navegacion-principal contenedor">
            <a href="#">Inicio</a>
            <a href="JuegosPS5.html">Juegos PS5</a>
            <a href="JuegosXbox.html">Juegos Xbox Series X</a>
            <a href="Controles.html">Controles</a>
        </nav>
    </div>
    
    <section class="hero">
        <div class="contenido-hero">
            <h2>Venta de Videojuegos <span> Online</span></h2> 
            <div class="ubicacion-carrito">
                <div class="ubicacion">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin" width="88" height="88" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFC107" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <circle cx="12" cy="11" r="3" />
                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 0 1 -2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z" />
                    </svg>
                    <p>Torreon, Coahuila</p>
                </div>
                <div class="carrito">
                    <img src="../assets/imagenes/Carrito.png" alt="Carrito de Compras" width="88" height="88">
                    <p>Mi Carrito de Compras</p>
                </div>
                
            </div>
            <a class="boton" href="#">Registrate</a>
        </div> <!-- .contenido-hero --> 
    </section>
    
    <style>
        .ubicacion-carrito {
            display: flex;
            align-items: center;
            gap: 20px; /* Espacio entre la ubicación y el carrito */
        }
        .ubicacion, .carrito {
            display: flex;
            align-items: center;
        }
        .ubicacion p, .carrito p {
            margin-left: 10px;
            font-size: 1.2rem;
        }
    </style>
    
    
    <main class="contenedor sombra">
        <h2>Nuestros Servicios</h2>

        <div class="servicios">
            <section class="servicio">
                <h3>Juegos PS5</h3>
                <div class="iconos">
                    <!-- Ícono de PS5 en formato PNG -->
                    <img src="../assets/imagenes/ps.png" alt="PS5 Icon" width="40" height="40">
                </div>
                <p> Catalogo del momento con videojuejos exclusivos de la plataforma Play Station , asi como Video Juegos variados recientemente salidos. </p>
            </section>
        
            <section class="servicio">
                <h3>Juegos Xbox Series X</h3>
                <div class="iconos">
                    <!-- Ícono de Xbox Series X en formato PNG -->
                    <img src="../assets/imagenes/xbox_logo_icon_169692.png" alt="Xbox Icon" width="40" height="40">
                </div>
                <p> Catalogo de juegos exclusivos y de ultima salida para la plataforma Xbox, asi como videojuegos variados no agregados en gamepass.</p>
            </section>
        
            <section class="servicio">
                <h3>Controles</h3>
                <div class="iconos">
                    <!-- Ícono de un control de consola en formato PNG -->
                    <img src="../assets/imagenes/control.svg" alt="Control Icon" width="40" height="40">
                </div>
                <p> Catalogo de controles ergonomicos de buena calidad y excelente precio ,para ambos tipos de plataforma. </p>
            </section>
        </div> <!--.servicios-->                
    </main>
    
    <footer class="footer">
        <p>Copyright © 2024 JE Videogames. Todos los derechos reservados.</p>
    </footer>



</body>
</html>