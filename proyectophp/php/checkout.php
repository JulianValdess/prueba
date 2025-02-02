<?php
require($_SERVER['DOCUMENT_ROOT'] . '/proyectophp/config/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/proyectophp/config/database.php');
//require 'config/database.php';

$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad){


$sql = $con->prepare("SELECT id, nombre, precio, $cantidad as cantidad FROM productos Where id=? and activo=1");
$sql->execute([$clave]);
$lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}
//session_destroy();

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
<!--Agregacion de barra de navegacion-->
<header data-bs-theme="dark">
  <div class="collapse text-bg-dark" id="navbarHeader">
    <div class="container">
      <div class="row">
        <div class="col-sm-4 offset-md-1 py-4">
          <h4>Contact</h4>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white">Follow on Twitter</a></li>
            <li><a href="#" class="text-white">Like on Facebook</a></li>
            <li><a href="#" class="text-white">Email me</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
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
                <a href="#" class="nav-link active">Catalogo</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Contacto</a>
            </li>            
        </ul>
        <!--Boton de acceso al carrito-->
        <a href="carrito.php" class="btn btn-primary">
          Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>
      </div>
    </div>
  </div>
</header>
<main>
    <!--Agregacion de los elementos de venta-->
    <main>
    <div class="container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th></th>
</tr>
</thead>
<tbody>
    <?php 
    if ($lista_carrito == null) {
        echo '<tr><td colspan="5" class="text-center"><b>Lista vacía</b></td></tr>';
    } else {
        $total = 0; // Variable para el total general

        foreach ($lista_carrito as $producto) {
            $_id = $producto['id'];
            $nombre = $producto['nombre'];
            $precio = $producto['precio'];
            $cantidad = $producto['cantidad'];
            $cantidad = $producto['cantidad'];
            
            // Calcular el subtotal (precio * cantidad)
            $subtotal = $precio * $cantidad;
            
            // Sumar el subtotal al total general
            $total += $subtotal;
            ?>
            <tr>
                <td><?php echo $nombre; ?> </td>
                <td><?php echo MONEDA . number_format($precio, 2, '.', ','); ?> </td>
                <td>
                    <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad; ?>"
                        size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
                </td>
                <td>
                    <!-- Mostrar el subtotal calculado -->
                    <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                        <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?>
                    </div>
                </td>
                <td>
                    <a href="#" id="eliminar" class="btn btn-warning btn-sm" 
                       data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">
                        Eliminar
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
        <!-- Mostrar el total general -->
        <tr>
            <td colspan="3"></td>
            <td colspan="2">
                <p class="h3" id="total">
                    <?php echo MONEDA . number_format($total, 2, '.', ','); ?>
                </p>
            </td>
        </tr>
    <?php } ?>
</tbody>

<?php  ?>
</table>
</div>

<?php 
    if ($lista_carrito != null) { ?>
<div class="row">
    <div class="col-md-5 offset-md-7 d-grid gap-2">
 <a href="pago.php" class="btn btn-primary btn-lg">Realizar pago </a>       
</div>
        </div>
        <?php } ?>
    </div>
   


</main>
<!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="eliminaModalLabel">Alerta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       Desea eliminar el producto de la lista?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button id='btn-elimina' type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
      </div>
    </div>
  </div>
</div>
    



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>

let eliminaModal = document.getElementById('eliminaModal')
eliminaModal.addEventListener('show.bs.modal', function(event){
  let button = event.relatedTarget
  let id = button.getAttribute('data-bs-id')
  let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
  buttonElimina.value = id
})


  function actualizaCantidad(cantidad, id) {
    let url = '/proyectophp/clases/actualizar_carrito.php'; // Ajusta según sea necesario
    let formData = new FormData();
    formData.append('action', 'agregar');
    formData.append('id', id);
    formData.append('cantidad', cantidad);

    fetch(url, {
      method: 'POST',
      body: formData,
      mode: 'cors'
    })
      .then(response => response.json()) // Cambiar a JSON directamente
      .then(data => {
        if (data.ok) {
          // Actualizar el subtotal del producto
          let divSubtotal = document.getElementById('subtotal_' + id);
          divSubtotal.innerHTML = data.sub;

          // Actualizar el total general
          let total = 0.0;
          let list = document.getElementsByName('subtotal[]');
          for (let i = 0; i < list.length; i++) {
            total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''));
          }

          // Formatear el total
          total = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
          }).format(total);

          document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total;
        }
      })
      .catch(error => console.error('Error:', error));
  }


  function eliminar() {
    let botonElimina = document.getElementById('btn-elimina')
    let id = botonElimina.value
    let url = '/proyectophp/clases/actualizar_carrito.php'; // Ajusta según sea necesario
    let formData = new FormData();
    formData.append('action', 'eliminar');
    formData.append('id', id);
    

    fetch(url, {
      method: 'POST',
      body: formData,
      mode: 'cors'
    })
      .then(response => response.json()) // Cambiar a JSON directamente
      .then(data => {
        if (data.ok) {
         location.reload()
        }
      })
      .catch(error => console.error('Error:', error));
  }
</script>

</body>
</html>