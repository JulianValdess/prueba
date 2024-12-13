<?php
require($_SERVER['DOCUMENT_ROOT'] . '/proyectophp/config/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/proyectophp/config/database.php');

$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, precio FROM productos Where activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JE Videogames</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/estilosinicio.css">
</head>
<body>
<header data-bs-theme="dark">
  <div class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a href="#" class="navbar-brand">        
        <strong>JE VIDEOGAMES</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarHeader">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a href="#" class="nav-link active">Catálogo</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Contacto</a>
            </li>            
        </ul>
        <a href="checkout.php" class="btn btn-primary">
          Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>
        <!-- Botón en el modal -->
<button onclick="window.location.href='AdminLogin.php'">ADMIN</button>
      </div>
    </div>
  </div>
</header>
<main>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach ($resultado as $row) { ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <?php
                        $id = $row['id'];
                        $imagen = "../assets/imagenes/$id/ControlXB.jpg";

                        if (!file_exists($imagen)) {
                            $imagen = "../assets/imagenes/nofoto.png";
                        }
                        ?>
                        <img src="<?php echo $imagen; ?>" class="card-img-top" alt="<?php echo $row['nombre']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                            <p class="card-text">$<?php echo number_format($row['precio'], 2, '.', ','); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                                <button class="btn btn-outline-success" type="button" 
                                onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">Agregar al carrito</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<!-- Modal para ADMIN Login -->
<div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adminModalLabel">Administrador - Inicio de sesión</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="admin_login.php" method="post">
          <div class="mb-3">
            <label for="adminUser" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="adminUser" name="username" required>
          </div>
          <div class="mb-3">
            <label for="adminPassword" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="adminPassword" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  function addProducto(id, token) {
    let url = '/proyectophp/clases/carrito.php';
    let formData = new FormData();
    formData.append('id', id);
    formData.append('token', token);

    fetch(url, {
      method: 'POST', 
      body: formData,
      mode: 'cors'
    })
    .then(response => response.json())
    .then(data => {
      if (data.ok) {
        let elemento = document.getElementById("num_cart");
        elemento.innerHTML = data.numero;
      }
    })
    .catch(error => console.error('Error:', error));
  }
</script>
</body>
</html>
