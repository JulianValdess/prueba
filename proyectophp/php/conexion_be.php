<?php

$conexion = mysqli_connect("localhost","root","","login_registro_db");

if($conexion)
{
    echo 'Conectado exitosamente a la base de datos';
}
else
{
    echo 'No se ah podido conectar a la base de datos';
}
?>