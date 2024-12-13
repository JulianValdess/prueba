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
}else{
    header("Location: paginicio.php");
    exit;
}


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

    <div class="row">
        <div class="col-6">
        <h4>Detalles de pago</h4>
        <div id="paypal-button-container"></div>
        </div>

        <div class="col-6">

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
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
                <td>
                    <!-- Mostrar el subtotal calculado -->
                    <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                        <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?>
                    </div>
                </td>
            </tr>
            <?php
        }
        ?>
        <!-- Mostrar el total general -->
        <tr>
            <td colspan="2">
                <p class="h3 text-end" id="total">
                    <?php echo MONEDA . number_format($total, 2, '.', ','); ?>
                </p>
            </td>
        </tr>
    <?php } ?>
</tbody>

<?php  ?>
</table>
</div>

        
    </div>
    </div>
    </div>
   


</main>

    



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>"></script>

<script>
    paypal.Buttons({
        style:{
            color: 'blue',
            shape: 'pill',
            label: 'pay'

        },
        createOrder: function(data, actions) {
    return actions.order.create({
        purchase_units: [{
            amount: {
                value: "<?php echo number_format($total, 2, '.', ''); ?>"
            }
        }]
    });
},

onApprove: function(data, actions) {
    let URL = '/proyectophp/clases/captura.php';
    actions.order.capture().then(function(detalles) {
        console.log(detalles);

        return fetch(URL, {
            method: 'post',
            headers: {
                'content-type': 'application/json'
            },
            body: JSON.stringify({
                detalles: detalles
            })
        }).then(response => response.json())
          .then(data => {
              console.log("Datos guardados en la base de datos:", data);
          }).catch(error => {
              console.error("Error al guardar los datos:", error);
          });
    });
},


        onCancel: function(data){
            alert("Pago cancelado");
            console.log(data);
        }
    }).render('#paypal-button-container');
    </script>
</body>
</html>