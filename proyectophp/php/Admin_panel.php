<?php

require($_SERVER['DOCUMENT_ROOT'] . '/proyectophp/config/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/proyectophp/config/database.php');


if (!isset($_SESSION['admin'])) {
    // Si no hay sesión, redirigir al login.
    header("Location: AdminLogin.php");
    exit();
}

// Crear una instancia de la base de datos.
$db = new Database();
$con = $db->conectar();

// Obtener productos de la base de datos.
$query = "SELECT * FROM productos";
$stmt = $con->prepare($query);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <style>
        /* Agrega aquí tus estilos personalizados */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
            border-radius: 5px;
        }
        .btn-danger {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <h1>Panel de Administración</h1>
    <a href="logout.php" class="btn">Cerrar Sesión</a>

    <h2>Lista de Productos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Descuento</th>
            <th>Categoría</th>
            <th>Activo</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?php echo $producto['id']; ?></td>
            <td><?php echo $producto['nombre']; ?></td>
            <td><?php echo $producto['descripcion']; ?></td>
            <td><?php echo $producto['precio']; ?></td>
            <td><?php echo $producto['descuento']; ?>%</td>
            <td><?php echo $producto['id_categoria']; ?></td> <!-- Aquí se asume que "id_categoria" es un campo numérico -->
            <td><?php echo $producto['activo'] ? 'Sí' : 'No'; ?></td>
            <td>
                <a href="editar_producto.php?id=<?php echo $producto['id']; ?>" class="btn">Editar</a>
                <a href="eliminar_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-danger">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Agregar Producto</h2>
    <form action="agregar_producto.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
        <br>
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>
        <br>
        <label for="descuento">Descuento (%):</label>
        <input type="number" id="descuento" name="descuento" step="0.01">
        <br>
        <label for="categoria">Categoría:</label>
        <select id="categoria" name="id_categoria" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <!-- Puedes agregar más categorías según sea necesario -->
        </select>
        <br>
        <label for="activo">Activo:</label>
        <input type="checkbox" id="activo" name="activo" value="1" checked>
        <br>
        <button type="submit" class="btn">Agregar Producto</button>
    </form>
</body>
</html>
