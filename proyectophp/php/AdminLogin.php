<?php
require $_SERVER['DOCUMENT_ROOT'] . '/proyectophp/config/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/proyectophp/config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Conectar a la base de datos
    $db = new Database();
    $con = $db->conectar();

    // Consulta para buscar al administrador
    $query = "SELECT * FROM administradores WHERE usuario = :username";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar si la contraseña es correcta (sin hash)
        if ($password == $admin['contraseña']) {
            $_SESSION['admin'] = $admin['usuario'];
            header("Location: Admin_panel.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Administrador</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-form h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .login-form label {
            font-size: 14px;
            color: #555;
            text-align: left;
            display: block;
            margin-bottom: 5px;
        }

        .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .login-form input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .login-form button {
            background-color: #4CAF50;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        .login-form button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        .login-form p {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .login-form p a {
            color: #4CAF50;
            text-decoration: none;
        }

        .login-form p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form class="login-form" method="POST" id="loginForm">
            <h2>Inicio de Sesión</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>

    <script>
        // Validación en JavaScript
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            const username = this.username.value.trim();
            const password = this.password.value.trim();

            // Validar Usuario
            if (username.length < 5 || username.length > 20) {
                alert('El nombre de usuario debe tener entre 5 y 20 caracteres.');
                e.preventDefault();
                return;
            }

            // Validar Contraseña
            if (password.length < 6) {
                alert('La contraseña debe tener al menos 6 caracteres.');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>
