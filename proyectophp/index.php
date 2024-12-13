<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@200..900&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesion para entrar a la pagina</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesion</button>
                </div>
                <div class="caja__trasera-registro">
                    <h3>¿Aun no tienes una cuenta?</h3>
                    <p>Registrate para que puedas iniciar sesion</p>
                    <button id="btn__iniciar-registrarse">Registrarse</button>
                </div>
            </div>

            <div class="contenedor__login-registro">
                <!--Formulario de inicio de sesion-->
                <form action="php/login.php" method="POST" class="formulario__login">
                   <h2>Iniciar sesión</h2>
                   <input type="text" placeholder="Correo Electrónico" name="correo">
                   <input type="password" placeholder="Contraseña" name="contraseña">
                    <button type="submit">Entrar</button>
                </form>
               <!--Formulario de inicio de registro-->
                <form action="php/registro_usuario_be.php" method="POST" class="formulario__registro">
                    <h2>Registrarse</h2>
                    <input type="text" placeholder="Nombre Completo" name="nombre_completo">
                    <input type="text" placeholder="Correo Electronico" name="correo">
                    <input type="text" placeholder="Usuario" name="usuario">
                    <input type="password" placeholder="Contraseña" name="contraseña">
                    <button>Registrarse</button>
                </form>

            </div>

        </div>

    </main>
    <script src="assets/js/script.js"></script>


</body>

</html>