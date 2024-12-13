<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion_be.php';

// Verifica si el formulario fue enviado mediante el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe el correo y la contraseña del formulario de inicio de sesión
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Verifica si ambos campos están completos
    if (empty($correo) || empty($contraseña)) {
        echo '<script>alert("Por favor, complete todos los campos."); window.location="../index.php";</script>';
        exit;
    }

    // Prepara una consulta SQL para seleccionar al usuario con el correo ingresado
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si el correo existe en la base de datos
    if ($result->num_rows === 1) {
        // Obtiene los datos del usuario
        $user = $result->fetch_assoc();

        // Verifica que la contraseña ingresada coincida con la contraseña en la base de datos
        if ($contraseña === $user['contraseña']) {
            // Inicia sesión y almacena el nombre de usuario en una sesión
            session_start();
            $_SESSION['usuario'] = $user['usuario']; // Guarda el usuario en la sesión

            // Redirige a la página principal (ej. tienda.php)
            header("Location: paginicio.php");
            exit();
        } else {
            echo '<script>alert("Contraseña incorrecta."); window.location="../index.php";</script>';
        }
    } else {
        echo '<script>alert("No existe una cuenta con ese correo."); window.location="../index.php";</script>';
    }

    // Cierra la conexión y la declaración
    $stmt->close();
    $conexion->close();
}
?>

