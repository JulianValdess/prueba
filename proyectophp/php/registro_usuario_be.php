<?php

include 'conexion_be.php';

$nombre_completo = $_POST['nombre_completo'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

$query = "INSERT INTO usuarios(nombre_completo,correo,usuario,contraseña)
VALUES('$nombre_completo','$correo','$usuario','$contraseña')";

$ejecutar = mysqli_query($conexion, $query);

if($ejecutar)
{
    echo '
    <script>
       alert("Registro Exitoso");
       window.location = "../index.php"
    </script>
    ';
}
else
{
    echo '
    <script>
       alert("Usuario no almacenado");
       window.location = "../index.php"
    </script>
    ';    
}

mysqli_close($conexion);
?>